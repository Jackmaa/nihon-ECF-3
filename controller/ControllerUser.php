<?php

class ControllerUser extends Controller {

    public function __construct(AltoRouter $router) {
        parent::__construct($router);
    }

    public function login() {
        $model = new ModelUser();
        $model->isConnected();

        //So normally we can access the $router globally with :
        // $this->router->generate('home');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (! empty($_POST['mail']) && ! empty($_POST['password'])) {
                $user = $model->getUser($_POST['mail']);
                if ($user && password_verify($_POST['password'], $user->getPassword())) {
                    $_SESSION['id']   = $user->getId_user();
                    $_SESSION['name'] = $user->getUsername();
                    header('Location: /nihon');
                    exit();
                } else {
                    $error = 'email or password is not valid';
                    require_once './view/login.php';
                }
            } else {
                $error = 'Fields are incorrect';
                require_once './view/login.php';
            }
        } else {
            require_once './view/login.php';
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: /nihon');
    }

    public function register() {

        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            if (! empty($_POST['email']) && ! empty($_POST['password']) && ! empty($_POST['password_verify'])) {

                if ($_POST['password'] === $_POST['password_verify']) {

                    $model = new ModelUser();

                    if ($model->checkUserMail($_POST['email']) && $model->checkUserName($_POST['username'])) {

                        $model->createUser($_POST['username'], $_POST['email'], $_POST['password']);
                        echo "Compte crée avec succès !";

                        require_once './view/home.php';
                    } else {
                        echo "Email or username is already taken.";
                        require_once './view/login.php';
                    }
                } else {
                    echo 'Passwords do not match.';
                    require_once './view/register.php';
                }
            } else {
                echo 'Email, password, and password verify are required.';
                require_once './view/register.php';
            }
        } else {
            require_once './view/register.php';
        }
    }
}