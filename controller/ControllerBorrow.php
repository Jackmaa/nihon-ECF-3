<?php
class BorrowController {
    public function borrow() {
        $model   = new ModelBorrow();
        $id_user = $_SESSION['id_user'];

        if ($model->userBorrowCount($id_user) >= $model->maxBooksAllowed($id_user)) {
            echo 'You have reached the maximum number of books allowed.';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (! empty($_POST['id_manga'])) {
                $borrow = new Borrow($_POST['id_manga'], $id_user);
                $model->save($borrow->getId_manga(), $borrow->getId_User(), $borrow->getBorrow_date(), $borrow->getReturn_date());
                echo 'Book borrowed successfully.';
            } else {
                echo 'All fields are required.';
            }
        }
    }
}
