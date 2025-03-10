<?php
class BorrowController {
    public function borrow() {
        if (! isset($_SESSION['user_id']) || ! isset($_POST['manga_id'])) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid data"]);
            return;
        }

        $manga_id   = (int) $_POST['manga_id'];
        $user_id    = (int) $_SESSION['user_id'];
        $extra_week = isset($_POST['extra_week']) && $_POST['extra_week'] === "true";

        // Check user's borrow limit
        $borrow_count = Borrow::userBorrowCount($user_id);
        $max_books    = Borrow::maxBooksAllowed($user_id);

        if ($borrow_count >= $max_books) {
            echo json_encode(["error" => "Borrow limit reached ($max_books books max)"]);
            return;
        }

        if (! Borrow::isAvailable($manga_id)) {
            echo json_encode(["error" => "Manga is already borrowed"]);
            return;
        }

        $borrow = new Borrow($manga_id, $user_id, $extra_week);
        if ($borrow->save()) {
            echo json_encode(["success" => "Manga successfully borrowed"]);
        } else {
            echo json_encode(["error" => "Error while borrowing"]);
        }
    }
}
