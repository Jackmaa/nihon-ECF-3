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
            $cart = Cart::addToCart(["id" => $id_manga, "volume" => $id_volume]);
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

        $borrow = new ModelBorrow();
        // Check borrow limits
        $current_borrows = $borrow->userBorrowCount($id_user);
        $max_books       = $borrow->maxBooksAllowed($id_user);

        if ($current_borrows + count($cart) > $max_books) {
            echo json_encode(["error" => "Borrow limit exceeded"]);
            return;
        }

        foreach ($cart as $manga) {
            if ($borrow->isAvailable($manga["id"], $manga["volume"])) {
                $borrow = new ModelBorrow();
                $borrow->save($manga["id"], $manga["volume"], $id_user);
            }
        }

        Cart::clearCart();
        echo json_encode(["success" => "Borrow confirmed"]);
    }
}
