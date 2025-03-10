<?php
class CartController extends Controller {
    public function __construct(AltoRouter $router) {
        parent::__construct($router);
    }
    public function add() {
        // Vérification des données
        if (! isset($_SESSION['id_user'])) {
            http_response_code(401);
            echo json_encode(["error" => "User not logged in"]);
            return;
        }

        // Récupération des données POST
        $data = json_decode(file_get_contents("php://input"), true);
        if (! isset($data['id_manga']) || ! isset($data['id_volume'])) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid data"]);
            return;
        }

        $id_manga  = (int) $data['id_manga'];
        $id_volume = (int) $data['id_volume'];

        try {
            $cart = Cart::addToCart([$id_manga, $id_volume]);
            echo json_encode(["success" => "Manga volume added to cart", "cart" => $cart]);
        } catch (InvalidArgumentException $e) {
            http_response_code(400);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }

    public function remove() {
        if (! isset($_SESSION['id_user']) || ! isset($_POST['id_manga']) || ! isset($_POST['id_volume'])) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid data"]);
            return;
        }

        $id_manga  = (int) $_POST['id_manga'];
        $id_volume = (int) $_POST['id_volume'];

        try {
            $cart = Cart::removeFromCart([$id_manga, $id_volume]);
            echo json_encode(["Success" => "Manga volume removed from cart", "cart" => $cart]);
        } catch (InvalidArgumentException $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
    public function confirmBorrow() {
        if (! isset($_SESSION['id_user'])) {
            http_response_code(400);
            echo json_encode(["error" => "User not logged in"]);
            return;
        }

        $id_user = (int) $_SESSION['id_user'];
        $cart    = Cart::getCart();

        if (empty($cart)) {
            echo json_encode(["error" => "Cart is empty"]);
            return;
        }

        $borrow          = new ModelBorrow();
        $current_borrows = $borrow->userBorrowCount($id_user);
        $max_books       = $borrow->maxBooksAllowed($id_user);

        if ($current_borrows + count($cart) > $max_books) {
            echo json_encode(["error" => "Borrow limit exceeded"]);
            return;
        }

        foreach ($cart as $manga) {
            list($id_manga, $id_volume) = $manga;
            if ($borrow->isAvailable($id_manga, $id_volume) > 0) {
                $borrow->save($id_manga, $id_volume, $id_user);
            }
        }

        Cart::clearCart();
        echo json_encode(["success" => "Borrow confirmed"]);
    }

    public function cart() {
        require_once './view/cart.php';
    }
}
