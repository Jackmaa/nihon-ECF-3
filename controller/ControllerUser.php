<?php
class ControllerUser extends Controller {
    public function __construct(AltoRouter $router) {
        parent::__construct($router);
    }

    // Handle user login
    public function login() {
        $model = new ModelUser();
        // On peut maintenant accéder à $this->router
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check if the email and password are set
            if (! empty($_POST['credential']) && ! empty($_POST['password'])) {
                // Fetch the user by email
                $user = $model->getUser($_POST['credential']);
                var_dump($user);
                // Check if the user exists and the password is correct
                if (password_verify($_POST['password'], $user->getPassword())) {
                    // Set the user ID in the session
                    $_SESSION['id_user'] = $user->getId_user();
                    $_SESSION['name']    = $user->getUsername();
                    header('Location: ' . $this->router->generate('home'));
                    exit;
                } else {
                    // Display an error message
                    echo 'Invalid email or password.';
                }
            } else {
                // Display an error message
                echo 'Email and password are required.';
            }
        }
        require_once './view/login.php';
    }

    // Handle user logout
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: ' . $this->router->generate('home'));
    }

    // Handle user registration
    public function register() {
        $token = bin2hex(random_bytes(32));
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (! empty($_POST['email']) && ! empty($_POST['password']) && ! empty($_POST['password_verify'])) {
                if ($_POST['password'] === $_POST['password_verify']) {
                    // Check if the password meets the regex criteria
                    $password        = $_POST['password'];
                    $passwordPattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
                    if (preg_match($passwordPattern, $password)) {
                        $model = new ModelUser();
                        if ($model->checkUserMail($_POST['email']) && $model->checkUserName($_POST['username'])) {
                            $username = $_POST['username'];
                            $email    = $_POST['email'];

                            // Create a temporary user entry
                            $insertResult = $model->createTempUser($username, $email, $password, $token);

                            // Send verification email
                            $mailer           = new Mailer($token);
                            $verificationLink = "http://nihon/verify/?email=$email&code=$token";
                            $sendResult       = $mailer->sendVerificationEmail($email, $username, $verificationLink);
                            var_dump($sendResult);
                            echo "Your account was created! An email has been sent, please check it out to verify your email.";

                            header('Location: ' . $this->router->generate('login'));
                        } else {
                            echo "Email or username is already taken.";
                            header('Location: ' . $this->router->generate('login'));
                        }
                    } else {
                        echo 'Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one number, and one special character.';
                        require_once './view/register.php';
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

    // Handle email verification
    public function verify() {
        $token = $_GET['code'] ?? '';
        $email = $_GET['email'] ?? '';

        if ($token && $email) {
            $model = new ModelUser();
            $timer = $model->verifyToken($token, $email);
            $now   = time();
            var_dump($timer);
            var_dump($now);
            if ($timer['expires_at'] > $now) {
                // Create a new user from the temporary user data
                $user = $model->getTempUser($email);
                $model->createUser($user['username'], $user['email'], $user['password']);
                $model->deleteTempUser($email);
                header('Location: ' . $this->router->generate('login'));
            } else {
                echo 'Your token has expired. A new link has been sent to your email.';
                $user             = $model->getTempUser($email);
                $username         = $user['username'];
                $email            = $user['email'];
                $password         = $user['password'];
                $token            = bin2hex(random_bytes(32));
                $mailer           = new Mailer($token);
                $verificationLink = "http://nihon/verify/?email=$email&code=$token";
                $mailer->sendVerificationEmail($email, $username, $verificationLink);
                $model->deleteTempUser($email);
                $model->createTempUser($username, $email, $password, $token);
            }
        } else {
            echo 'Please provide a valid token and email.';
        }
    }

    public function update(int $id) {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (! empty($_POST['username']) && ! empty($_POST['email']) && ! empty($_POST['password']) && ! empty($_POST['password_verify']) && ! empty($_POST['profile_pic'])) {
                if ($_POST['password'] === $_POST['password_verify']) {
                    $model = new ModelUser();
                    $model->updateUser($_POST['username'], $_POST['email'], $_POST['password'], $_POST['profile_pic']);
                    echo 'Your account has been updated.';
                    header('Location: ' . $this->router->generate('home'));
                } else {
                    echo 'Passwords do not match.';
                }
            } else {
                echo 'All the fields are required.';
            }
        }
        require_once './view//updateUser.php';
    }

    public function myProfile() {
        require_once './view/myProfile.php';
    }
}