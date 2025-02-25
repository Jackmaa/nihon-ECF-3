<?php

require_once './entity/Mailer.php';

class ControllerUser extends Controller{

    // Handle user login
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

    // Handle user logout
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: /nihon');
    }

    // Handle user registration
    public function register() {

        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            if (! empty($_POST['email']) && ! empty($_POST['password']) && ! empty($_POST['password_verify'])) {

                if ($_POST['password'] === $_POST['password_verify']) {

                    $model = new ModelUser();

                    if ($model->checkUserMail($_POST['email']) && $model->checkUserName($_POST['username'])) {
                        $username = $_POST['username'];
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $verificationCode = $this->generateVerificationCode();//VERIFIERRRRRRRRRRRRRRRRR

                        $insertResult = $model->createUser($_POST['username'], $_POST['email'], $_POST['password'], $verificationCode);

                        if ($insertResult === true) {
                            // Envoyer l'email de vérification
                            $mailer = new Mailer();
                            $verificationLink = "http://tonsite.com/verify.php?email=$email&code=$verificationCode";
                            $sendResult = $mailer->sendVerificationEmail($email, $username, $verificationLink);
                            if ($sendResult === true) {
                                echo "Compte créé avec succès ! Un email de vérification a été envoyé.";
                            } else {
                                echo $sendResult;
                                require_once './view/register.php';
                            }
                        }
    
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

    private function generateVerificationCode($length = 6) {
        $characters = '0123456789';
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $code;
    }
}