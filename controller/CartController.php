<?php
class CartController {
    public function add() {
        if (! isset($_SESSION['id_user']) || ! isset($_POST['id_manga']) || ! isset($_POST['id_volume'])) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid data"]);
            return;
        }

        $id_manga  = (int) $_POST['id_manga'];
        $id_volume = (int) $_POST['id_volume'];

        try {
            $cart = Cart::addToCart([$id_manga, $id_volume]);
            echo json_encode(["Success" => "Manga volume added to cart", "cart" => $cart]);
        } catch (InvalidArgumentException $e) {
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
            $cart = Cart::addToCart([$id_manga, $id_volume]);
            echo json_encode(["Success" => "Manga volume removed from cart", "cart" => $cart]);
        } catch (InvalidArgumentException $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
    public function confirmBorrow() {
        if (! isset($_SESSION['user_id'])) {
            http_response_code(400);
            echo json_encode(["error" => "User not logged in"]);
            return;
        }

        $user_id = (int) $_SESSION['user_id'];
        $cart    = Cart::getCart();

        if (empty($cart)) {
            echo json_encode(["error" => "Cart is empty"]);
            return;
        }

        // Check borrow limits
        $current_borrows = Borrow::userBorrowCount($user_id);
        $max_books       = Borrow::maxBooksAllowed($user_id);

        if ($current_borrows + count($cart) > $max_books) {
            echo json_encode(["error" => "Borrow limit exceeded"]);
            return;
        }

        foreach ($cart as $manga_id) {
            if (Borrow::isAvailable($manga_id)) {
                $borrow = new Borrow($manga_id, $user_id);
                $borrow->save();
            }
        }

        Cart::clearCart();
        echo json_encode(["success" => "Borrow confirmed"]);
    }
}
