<?php
class ControllerUser extends Controller {
    public function __construct(AltoRouter $router) {
        parent::__construct($router);
    }

    // Handle user login
    public function login() {
        $model = new ModelUser();
        if (isset($_SESSION['admin_logged_in'])) {
            session_unset();
        }
        if (isset($_SESSION['id_user'])) {
            header('Location: ' . $this->router->generate('home'));
            exit;
        }
        // On peut maintenant accéder à $this->router
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check if the email and password are set
            if (! empty($_POST['credential']) && ! empty($_POST['password'])) {
                // Fetch the user by email
                if ($user = $model->getUser($_POST['credential'])) {
                    if (password_verify($_POST['password'], $user->getPassword())) {
                        // Set the user ID in the session
                        $_SESSION['id_user']     = $user->getId_user();
                        $_SESSION['name']        = $user->getUsername();
                        $_SESSION['profile_pic'] = $user->getProfile_pic();
                        header('Location: ' . $this->router->generate('home'));
                        exit;
                    } else {
                        // Display an error message
                        echo 'Invalid email or password.';
                    }
                } else {
                    echo 'you are not registered';
                }
            } else {
                echo 'Email and password are required.';
            }
        } else {
            require_once './view/login.php';
        }
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
            if ($timer['expires_at'] > $now) {
                // Create a new user from the temporary user data
                $model = new ModelUser();
                $user  = $model->getTempUser($email);
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

    // Handle user verification from admin dashboard
    public function verifyUser() {
        $token = $_GET['code'] ?? '';
        $model = new ModelUser();

        // If the request is GET, retrieve the email and store it in session
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $email = $model->getEmailByToken($token);
            if (! $email) {
                die('Invalid or expired token.');
            }
            $_SESSION['email_verification'] = $email; // Store email in session
        }

        // Retrieve email from session for POST requests
        $email = $_SESSION['email_verification'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (! empty($_POST["username"]) && ! empty($_POST["password"]) && ! empty($_POST["password_verify"])) {
                if ($_POST["password"] === $_POST["password_verify"]) {
                    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
                    $model->deleteTempUser($email);
                    $model->createUser($_POST["username"], $email, $password);

                    // Clean up session after user creation
                    unset($_SESSION['email_verification']);

                    header('Location: ' . $this->router->generate('home'));
                    exit;
                } else {
                    echo "Passwords do not match.";
                }
            } else {
                echo "All fields are required.";
            }
        }

        require_once './view/finishsignup.php';
    }

    // Function to handle user account updates
    public function update(int $id) {
        // Check if the request method is POST (form submission)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new ModelUser();          // Instantiate the user model
            $user  = $model->getUserById($id); // Fetch existing user data by ID

            // Update username and email if provided, otherwise keep existing values
            $username = ! empty($_POST['username']) ? $_POST['username'] : $user->getUsername();
            $email    = ! empty($_POST['email']) ? $_POST['email'] : $user->getEmail();

            // Handle password update only if both password fields are provided
            if (! empty($_POST['password']) && ! empty($_POST['password_verify'])) {
                if ($_POST['password'] === $_POST['password_verify']) {
                    // Hash the new password
                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                } else {
                    // Exit if passwords do not match
                    echo 'Passwords do not match.';
                    exit();
                }
            } else {
                // Keep the existing password if no new password is provided
                $password = $user->getPassword();
            }

                                                   // Handle profile picture update if a new file is uploaded
            $profilePic = $user->getProfile_pic(); // Keep existing profile picture by default
            if (! empty($_FILES['profile_pic'])) {
                // Call the function to handle the file upload and processing
                $profilePic = $this->handleThumbnailUpload($_FILES['profile_pic'], "user$id");
            }

            // Update the user data in the database
            $model->updateUser($username, $email, $password, $profilePic, $id);

            // Update the session with the new profile picture
            $_SESSION['profile_pic'] = $profilePic;

            // Notify the user and redirect to their profile page
            echo 'Your account has been updated.';
            header('Location: ' . $this->router->generate('myProfile', ['id' => $id]));
            exit();
        }

        // If the request is not POST, fetch the user data and load the update form
        $model = new ModelUser();
        $user  = $model->getUserById($id);

        // Include the view for updating user information
        require_once './view/updateUser.php';
    }

// Function to handle file uploads and image processing
    private function handleThumbnailUpload($file, $fileName) {
        $targetDir = "C:/wamp64/www/nihon/public/asset/img/profile_pic/"; // Directory for profile pictures

        // Get the file extension and validate it against allowed types
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedTypes  = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (! in_array($fileExtension, $allowedTypes)) {
            // Return false if the file type is not allowed
            return false;
        }

        // Define file paths for temporary and final files
        $tempFilePath  = $targetDir . $fileName . "." . $fileExtension;
        $finalFilePath = $targetDir . $fileName . ".webp";

        // Move the uploaded file to the temporary location
        if (! move_uploaded_file($file['tmp_name'], $tempFilePath)) {
            // Return false if the file could not be moved
            return false;
        }

        // Convert and resize the image to WebP format
        if (ImageProcessor::processImage($tempFilePath, $finalFilePath, 100, 100)) {
            // Remove the base path from the final file path and return it
            $finalFilePath = str_replace("C:/wamp64/www/nihon/", '', $finalFilePath);
            return $finalFilePath;
        }

        // Return false if image processing fails
        return false;
    }

    public function myProfile($id) {
        $model      = new ModelUser();
        $data       = $model->profile($id);
        $borrow     = new ModelBorrow();
        $maxBooks   = $borrow->maxBooksAllowed($_SESSION['id_user']);
        $currentRes = $borrow->totalReservationsAndBorrows();
        require_once './view/myProfile.php';

    }

    public function currentStorie() {
        if (! isset($_SESSION['id_user'])) {
            header('Location: ' . $this->router->generate('login'));
            exit;
        } else {
            $model  = new ModelBorrow;
            $datas  = $model->getUserBorrows($_SESSION['id_user']);
            $mangas = [];
            foreach ($datas as $data) {
                $manga    = new ModelManga;
                $mangaDTO = $manga->getMangaById($data->getId_Manga());
                $mangas[] = new BorrowDTO($data, $mangaDTO);
            }
            require_once './view/currentStorie.php';
        }
    }

    public function favoriteManga() {
        $model     = new ModelManga();
        $userstats = $model->getStats($_SESSION['id_user']);
        $mangas    = $model->getUserFavs($_SESSION['id_user']);
        $favs      = [];
        foreach ($mangas as $manga) {
            $favs[] = $model->getMangaById($manga->getId_Manga());
        }
        require_once './view/favoriteManga.php';
    }

    public function pastChronicle() {
        if (! isset($_SESSION['id_user'])) {
            header('Location: ' . $this->router->generate('login'));
            exit;
        } else {
            $model  = new ModelBorrow;
            $datas  = $model->getUserPastBorrows($_SESSION['id_user']);
            $mangas = [];
            foreach ($datas as $data) {
                $manga    = new ModelManga;
                $mangaDTO = $manga->getMangaById($data->getId_Manga());
                $mangas[] = new BorrowDTO($data, $mangaDTO);

            }
            require_once './view/pastChronicle.php';
        }
    }

    public function buyPremium() {
        if (! isset($_SESSION['id_user'])) {
            header('Location: ' . $this->router->generate('login'));
            exit;
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new ModelUser();
            $model->buyPremium($_SESSION['id_user']);
            header('Location: ' . $this->router->generate('myProfile', ['id' => $_SESSION['id_user']]));
        }
    }
}