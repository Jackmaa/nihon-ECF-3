<?php
class ControllerAdmin extends Controller {
    public function __construct(AltoRouter $router) {
        parent::__construct($router);
    }

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
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['id_admin']        = $user->getId_user();

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

    public function dashboard() {
        if (! isset($_SESSION['admin_logged_in'])) {
            header('Location: ' . $this->router->generate('admin_login'));
            exit;
        }

        require_once './view/admin_dashboard.php';
    }
}