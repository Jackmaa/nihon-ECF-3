<?php
class ControllerAdmin extends Controller {
    public function __construct(AltoRouter $router) {
        parent::__construct($router);
    }

    // Admin login
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (! isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die("Invalid CSRF Token");
            }

            $credential = $_POST['credential'];
            $password   = $_POST['password'];

            $model = new ModelUser();
            $user  = $model->getUser($credential);
            if (password_verify($password, $user->getPassword()) && $user->getId_role() === 2) {
                session_unset();
                session_start();
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['id_admin']        = $user->getId_user();
                $borrow                      = new ModelBorrow;
                $borrow->clearExpiredReservations();
                $borrow->updateStatusLateReturns();
                header('Location: ' . $this->router->generate('admin_dashboard'));
                exit;
            } else {
                echo 'Invalid email or password.';
            }
        }

        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        require_once './view/admin_login.php';
    }

    // Admin dashboard
    public function dashboard() {
        if (! isset($_SESSION['admin_logged_in'])) {
            header('Location: ' . $this->router->generate('admin_login'));
            exit;
        }
        $manga      = new ModelManga();
        $categories = $manga->getCategories();
        $editors    = $manga->getEditorList();
        $model      = new ModelBorrow();
        $borrows    = $model->getBorrowedBooks();
        $enumValues = $model->getStatusEnum();
        $reviews    = $manga->getAllReviews();
        require_once './view/admin_dashboard.php';
    }

    // Search for a manga
    public function searchManga() {
        $search        = '%' . $_POST['search'] . '%';
        $model         = new ModelManga();
        $searchResults = $model->searchAdminManga($search);
        if (empty($searchResults)) {
            $searchResults = ['error' => 'No results found'];
        }
        header('Content-Type: application/json');
        echo json_encode($searchResults, JSON_PRETTY_PRINT);
    }

    //Manage a review in case of inappropriate content
    public function manageReview($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_review'])) {
            $id_review = $_POST['id_review']; // Récupération correcte de la review
            $model     = new ModelManga();
            $model->deleteReview($id_review);

            header("Location:" . $this->router->generate("read", ["id" => $id]));
            exit;
        }
    }

    public function deleteReview($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new ModelManga();
            $model->deleteReview($id);
            echo json_encode(['success' => true, 'review_id' => $id]);
        }
    }

    // Search for a user
    public function searchUser() {
        $search        = '%' . $_POST['search'] . '%';
        $model         = new ModelUser();
        $searchResults = $model->searchUser($search);
        if (empty($searchResults)) {
            $searchResults = ['error' => 'No results found'];
        }
        header('Content-Type: application/json');
        echo json_encode($searchResults, JSON_PRETTY_PRINT);
    }

    //Create a User if no results found
    public function createUser() {
        $token = bin2hex(random_bytes(32));
        $email = $_POST['email'];
        $model = new ModelUser();
        $model->createUserByAdmin($email, $token);

        $mailer = new Mailer($token);
        $link   = "http://nihon/finishsignup/?email=$email&code=$token";
        $mailer->sendFinishSignupEmail($email, $link);
    }

    //Method to update the Status of Borrowed Manga
    public function adminBorrowStatus() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['id_borrow']) && isset($data['status'])) {
            $id_borrow = intval($data['id_borrow']);
            $status    = htmlspecialchars($data['status']);
            $model     = new ModelBorrow;
            if ($model->updateStatus($id_borrow, $status)) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false]);
            }
        }
    }

    public function getUserItems($userId) {

        $model    = new ModelBorrow;
        $borrowed = $model->getUserBorrowsAdmin($userId);
        $cart     = $model->getUserReservationsAdmin($userId);

        echo json_encode([
            "borrowed" => $borrowed,
            "cart"     => $cart,
        ]);
    }

    public function modifyUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name    = $_POST['name'];
            $email   = $_POST['email'];
            $role    = $_POST['role'];
            $premium = $_POST['premium'];
            $model   = new ModelUser();
            $model->updateUserByAdmin($name, $email, $role, $premium);

            header('Location: ' . $this->router->generate('admin_dashboard'));
            exit;
        }
    }
}