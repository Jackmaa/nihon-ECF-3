<?php
class CartController extends Controller {
    public function __construct(AltoRouter $router) {
        parent::__construct($router);
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

        // Check if the cart session is set
        if (! isset($_SESSION['cart'])) {
            $_SESSION['cart'] = []; // Initialize cart if empty
        }

        // Check the user's max borrow limit
        $borrow   = new ModelBorrow();
        $maxBooks = $borrow->maxBooksAllowed($_SESSION['id_user']);

        if (count($_SESSION['cart']) >= $maxBooks) {
            http_response_code(400);
            echo json_encode(["error" => "Your cart is already at the limit allowed."]);
            return;
        }

        try {
            // Add the item to the cart
            $cart = Cart::addToCart([$id_manga, $id_volume]);
            // Add the item to the reservation table
            $borrow->addToReservationTable($_SESSION['id_user'], $id_manga, $id_volume);
            echo json_encode(["success" => "Manga volume added to cart", "cart" => $cart]);
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
            // Remove the item from the cart
            $cart = Cart::removeFromCart(["id_manga" => $id_manga, "id_volume" => $id_volume]);

            // Optionally, remove the item from the reservation table
            $borrow = new ModelBorrow();
            $borrow->removeFromReservationTable($_SESSION['id_user'], $id_manga, $id_volume);

                                     // Return success response
            http_response_code(200); // OK
            echo json_encode(["success" => "Manga volume removed from cart", "cart" => $cart]);
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
        // Check if the user is logged in
        if (! isset($_SESSION['id_user'])) {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "User not logged in"]);
            return;
        }

        // Get the user ID and the current cart
        $id_user = (int) $_SESSION['id_user'];
        $cart    = Cart::getCart();

        // Check if the cart is empty
        if (empty($cart)) {
            echo json_encode(["error" => "Cart is empty"]);
            return;
        }

        // Initialize the borrow model
        $borrow          = new ModelBorrow();
        $current_borrows = $borrow->userBorrowCount($id_user); // Get the current number of borrows
        $max_books       = $borrow->maxBooksAllowed($id_user); // Get the maximum allowed books

        // Check if the borrow limit is exceeded
        if ($current_borrows + count($cart) > $max_books) {
            echo json_encode(["error" => "Borrow limit exceeded"]);
            return;
        }

        // Process each item in the cart
        foreach ($cart as $manga) {
            var_dump($manga);
            $id_manga  = $manga["id_manga"];
            $id_volume = $manga["id_volume"];
            if ($borrow->isAvailable($id_manga, $id_volume) > 0) { // Check if the item is available
                $borrow->save($id_manga, $id_volume, $id_user);        // Save the borrow record
                $borrow->removeFromReservationTable($id_user, $id_manga, $id_volume);
            }
        }

        // Clear the cart after confirming the borrow
        Cart::clearCart();

        $_SESSION["message"] = "Your validation has been validated, check your emails for your QR code to retrieve your books.";
        header("location:" . $this->router->generate("home"));
    }

    public function clearCart() {
        Cart::clearCart();
        $borrow = new ModelBorrow();
        $borrow->clearCart($_SESSION['id_user']);
        require_once './view/cart.php';
    }

    // Renders the cart view
    public function cart() {
        require_once './view/cart.php';
    }

    public function cartState() {
        $model = new ModelUser;
        $cart  = $model->fetchCartData($_SESSION['id_user']);
        echo json_encode(["success" => true, "cart" => $cart]);
    }
}