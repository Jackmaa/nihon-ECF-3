<?php
class CartController extends Controller {
    public function __construct(AltoRouter $router) {
        parent::__construct($router);
    }

    private function processBorrow($id_user, $id_manga, $id_volume) {
        $borrow = new ModelBorrow();

        // Vérifier si le volume est disponible
        if ($borrow->isAvailable($id_manga, $id_volume) > 0) {
            $borrow->save($id_manga, $id_volume, $id_user);                       // Enregistre l'emprunt
            $borrow->removeFromReservationTable($id_user, $id_manga, $id_volume); // Supprime de la réservation
            return true;
        }
        return false;
    }

    public function add() {
        // Check if the user is logged in
        if (! isset($_SESSION['id_user'])) {
            http_response_code(401); // Unauthorized
            echo json_encode(["error" => "User not logged in"]);
            return;
        }

        // Decode the JSON input from the request
        $data = json_decode(file_get_contents("php://input"), true);

        // Validate the input data
        if (empty($data['id_manga']) || empty($data['id_volume'])) {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "Invalid data"]);
            return;
        }

        // Extract manga and volume IDs from the input
        $id_manga  = (int) $data['id_manga'];
        $id_volume = (int) $data['id_volume'];

        // Ensure IDs are valid
        if ($id_manga <= 0 || $id_volume <= 0) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid manga or volume ID"]);
            return;
        }

        // Check the user's max borrow limit
        $borrow     = new ModelBorrow();
        $maxBooks   = $borrow->maxBooksAllowed($_SESSION['id_user']);
        $currentRes = $borrow->totalReservationsAndBorrows();

        if ($currentRes['total_entries'] >= $maxBooks) {
            http_response_code(400);
            echo json_encode(["error" => "Your cart is already at the limit allowed."]);
            return;
        }

        try {
            // Add the item to the reservation table
            $borrow->addToReservationTable($_SESSION['id_user'], $id_manga, $id_volume);
            echo json_encode(["success" => "Manga added to cart."]);
        } catch (InvalidArgumentException $e) {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => $e->getMessage()]);
        } catch (Exception $e) {
            http_response_code(400);                         // Bad Request
            echo json_encode(["error" => $e->getMessage()]); // Catches duplicate cart items or other exceptions
        }
    }

    public function remove() {
        // Check if the user is logged in
        if (! isset($_SESSION['id_user'])) {
            http_response_code(401); // Unauthorized
            echo json_encode(["error" => "User not logged in"]);
            return;
        }

        $data = json_decode(file_get_contents("php://input"), true);

        if (! is_array($data)) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid request data."]);
            return;
        }

        // Check if the required data is provided
        if (empty($data['id_manga']) || empty($data['id_volume'])) {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "Invalid data: manga or volume ID is missing"]);
            return;
        }

        // Extract manga and volume IDs from the input
        $id_manga  = (int) $data['id_manga'];
        $id_volume = (int) $data['id_volume'];

        // Ensure IDs are valid
        if ($id_manga <= 0 || $id_volume <= 0) {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "Invalid manga or volume ID"]);
            return;
        }

        try {

            // Optionally, remove the item from the reservation table
            $borrow = new ModelBorrow();
            $borrow->removeFromReservationTable($_SESSION['id_user'], $id_manga, $id_volume);
            http_response_code(200); // OK
            echo json_encode(["success" => "Manga removed from cart."]);
        } catch (InvalidArgumentException $e) {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => $e->getMessage()]);
        } catch (Exception $e) {
            http_response_code(500); // Internal Server Error
            echo json_encode(["error" => "An unexpected error occurred: " . $e->getMessage()]);
        }
    }
    // Handles confirming a borrow request
    public function validateCart() {
        $id_user = $_SESSION['id_user'];
        $model   = new ModelBorrow();
        $cart    = $model->getUserReservations($id_user);

        foreach ($cart as $item) {
            $model->removeFromReservationTable($id_user, $item["id_manga"], $item["id_volume"]);
            $model->save($item["id_manga"], $item["id_volume"], $id_user);
        }
        header('Location:' . $this->router->generate("home"));
    }

    public function validateCartItem() {

        $data = json_decode(file_get_contents("php://input"), true);
        if (empty($data['id_manga']) || empty($data['id_volume'])) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid data"]);
            return;
        }

        $id_user   = (int) $data['id_user'];
        $id_manga  = (int) $data['id_manga'];
        $id_volume = (int) $data['id_volume'];

        if ($this->processBorrow($id_user, $id_manga, $id_volume)) {
            echo json_encode(["success" => "Manga volume validated"]);
        } else {
            echo json_encode(["error" => "Manga not available"]);
        }
    }

    public function clearCartItems() {
        $model = new ModelBorrow();
        $id_user = $_SESSION['id_user'];
        $cartItems = $model->getUserReservations($_SESSION['id_user']);

        foreach ($cartItems as $item) {
            $model->removeFromReservationTable($id_user, $item['id_manga'], $item['id_volume']);
        }

        header('Location:' . $this->router->generate("home"));
    }

    public function deleteCartItem() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (empty($data['id_manga']) || empty($data['id_volume'])) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid data"]);
            return;
        }

        $id_user   = (int) $data['id_user'];
        $id_manga  = (int) $data['id_manga'];
        $id_volume = (int) $data['id_volume'];

        $model = new ModelBorrow();
        if ($model->deleteItemFromCart($id_user, $id_manga, $id_volume)) {
            echo json_encode(["success" => "Manga removed from cart."]);
        } else {
            echo json_encode(["error" => "Failed"]);
        }
    }

    // Renders the cart view
    public function cart() {
        if (! isset($_SESSION['id_user'])) {
            require_once './view/login.php';
        } else {
            $model = new ModelBorrow;
            $cart  = $model->getUserReservations($_SESSION['id_user']);
            require_once './view/cart.php';
        }
    }

    public function cartState() {
        $model = new ModelUser;
        $cart  = $model->fetchCartData($_SESSION['id_user']);
        echo json_encode(["success" => true, "cart" => $cart]);
    }

    public function getUserCartItems() {
        if (! isset($_GET['userId'])) {
            echo json_encode(["error" => "Missing user ID"]);
            return;
        }
        $model  = new ModelBorrow;
        $userId = intval($_GET['userId']);
        $items  = $model->getUserReservations($userId);
        echo json_encode($items);
    }

    public function getUserBorrowedItems() {
        if (! isset($_GET['userId'])) {
            echo json_encode(["error" => "Missing user ID"]);
            return;
        }
        $model  = new ModelBorrow;
        $userId = intval($_GET['userId']);
        $items  = $model->getUserBorrows($userId);
        echo json_encode($items);
    }
}