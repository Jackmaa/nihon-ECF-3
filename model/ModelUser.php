<?php

class ModelUser extends Model {
    // Retrieve user details by email or username
    public function getUser(string $credential) {
        $req = $this->getDb()->prepare('SELECT `id_user`, `username`, `email`, `password`, `signing_date`, `id_role`, `profile_pic`, `premium` FROM `user` WHERE `email` = :credential OR `username` = :credential');
        $req->bindParam(':credential', $credential, PDO::PARAM_STR);
        $req->execute();

        $data = $req->fetch(PDO::FETCH_ASSOC);
        return $data ? new User($data) : null;
    }

    //Retrieve user details by id
    public function getUserById(int $id) {
        $req = $this->getDb()->prepare('SELECT `id_user`, `username`, `email`, `password`, `signing_date`, `id_role`, `profile_pic`, `premium` FROM `user` WHERE `id_user` = :id_user');
        $req->bindParam(':id_user', $id, PDO::PARAM_INT);
        $req->execute();

        $data = $req->fetch(PDO::FETCH_ASSOC);
        return $data ? new User($data) : null;
    }

    // Check if the user is already connected
    public function isConnected() {
        if ($_SESSION) {
            header('Location: /nihon');
        }
    }

    // Check if the email is already registered
    public function checkUserMail(string $email) {

        $user = $this->getDb()->prepare('SELECT `email` FROM user WHERE `email` = :email');
        $user->bindParam(':email', $email, PDO::PARAM_STR);
        $user->execute();
        $data = $user->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return false;
        } else {
            return true;
        }
    }

    // Check if the username is already taken
    public function checkUserName(string $username) {

        $user = $this->getDb()->prepare('SELECT `username` FROM user WHERE `username` = :username');
        $user->bindParam(':username', $username, PDO::PARAM_STR);
        $user->execute();
        $data = $user->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return false;
        } else {
            return true;
        }
    }

    //Create pending user
    public function createUser(string $username, string $email, string $password) {
        $default_image = [
            'public\asset\img\profile pic\izuku.webp',
            'public\asset\img\profile pic\luffy.webp',
            'public\asset\img\profile pic\minato.webp',
            'public\asset\img\profile pic\tanjiro.webp',
            'public\asset\img\profile pic\shrek.webp',
        ];

        $random_image = $default_image[array_rand($default_image)];

        $user = $this->getDb()->prepare(
            'INSERT INTO
                `user` (`username`, `email`, `password`, `signing_date`, `profile_pic`)
            VALUES
                (:username, :email, :password, NOW(), :profile_pic)');

        $user->bindParam(':username', $username, PDO::PARAM_STR);
        $user->bindParam(':email', $email, PDO::PARAM_STR);
        $user->bindParam(':password', $password, PDO::PARAM_STR);
        $user->bindParam(':profile_pic', $random_image, PDO::PARAM_STR);
        $user->execute();
    }

    public function createTempUser(string $username, string $email, string $password, string $token) {
        $expiryTime = time() + (15 * 60);
        $user       = $this->getDb()->prepare('INSERT INTO `email_verify` (`username`, `email`, `password`, `expires_at`, `token`) VALUES (:username, :email, :password, :expires_at, :token)');
        $password   = password_hash($password, PASSWORD_BCRYPT, ['cost' => $this->setCost(0.250)]);
        $user->bindParam(':username', $username, PDO::PARAM_STR);
        $user->bindParam(':email', $email, PDO::PARAM_STR);
        $user->bindParam(':password', $password, PDO::PARAM_STR);
        $user->bindParam(':expires_at', $expiryTime, PDO::PARAM_INT);
        $user->bindParam(':token', $token, PDO::PARAM_STR);
        $user->execute();

    }

    public function getEmailByToken($token) {
        $query = $this->getDb()->prepare("SELECT email FROM email_verify WHERE token = ?");
        $query->execute([$token]);
        $email = $query->fetchColumn();

        if (! $email) {
            error_log("Token not found in DB: " . $token); // Log si le token ne correspond pas
        }

        return $email;
    }

    public function verifyToken(string $token, string $email) {
        $req = $this->getDb()->prepare('SELECT`expires_at` FROM `email_verify` WHERE `token` = ? AND `email`  = ?');
        $req->execute([$token, $email]);
        $expiringTimer = $req->fetch(PDO::FETCH_ASSOC);
        return $expiringTimer;
    }

    public function getTempUser(string $email) {
        $req = $this->getDb()->prepare('SELECT `username`, `email`, `password` FROM `email_verify` WHERE `email` = ?');
        $req->execute([$email]);
        $data = $req->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function deleteTempUser(string $email) {
        $req = $this->getDb()->prepare('DELETE FROM `email_verify` WHERE `email` = ?');
        $req->execute([$email]);
    }

    public function updateUser(string $username, string $email, string $password, string $profile_pic, int $id_user) {
        $req = $this->getDb()->prepare('UPDATE `user` SET `username` = :username, `email` = :email, `password` = :password, `profile_pic` = :profile_pic WHERE `id_user` = :id_user');
        $req->bindParam(':username', $username, PDO::PARAM_STR);
        $req->bindParam(':email', $email, PDO::PARAM_STR);
        $req->bindParam(':password', $password, PDO::PARAM_STR);
        $req->bindParam(':profile_pic', $profile_pic, PDO::PARAM_STR);
        $req->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $req->execute();
    }

    public function profile(int $id) {
        $req = $this->getDb()->prepare('SELECT `id_user`, `username`, `email`, `password`, `profile_pic` FROM `user` WHERE `id_user` = :id_user'); //UPDATED EDIT PROFILE METHOD
        $req->bindParam(':id_user', $id, PDO::PARAM_INT);
        $req->execute();
        $data = $req->fetch(PDO::FETCH_ASSOC);

        return $data ? new User($data) : null;
    }

    public function searchUser($str) {
        $req = $this->getDb()->prepare('SELECT * FROM `user` WHERE `username` OR `email` LIKE :str');
        $req->bindParam(':str', $str, PDO::PARAM_STR);
        $req->execute();
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User($data);
        }
        return $users ?? null;
    }

    public function createUserByAdmin(string $email, string $token) {
        $expiryTime = time() + (15 * 60);
        $req        = $this->getDb()->prepare('INSERT INTO `email_verify` (`email`, `token`, `expires_at`) VALUES (:email, :token, :expires_at)');
        $req->bindParam(':email', $email, PDO::PARAM_STR);
        $req->bindParam(':token', $token, PDO::PARAM_STR);
        $req->bindParam(':expires_at', $expiryTime, PDO::PARAM_INT);
        $req->execute();
    }

    public function updateUserByAdmin(string $username, string $email, int $role, bool $premium) {
        $req = $this->getDb()->prepare('UPDATE `user` SET `username` = :username, `email` = :email, `id_role` = :role, `premium` = :premium WHERE `email` = :email');
        $req->bindParam(':username', $username, PDO::PARAM_STR);
        $req->bindParam(':email', $email, PDO::PARAM_STR);
        $req->bindParam(':role', $role, PDO::PARAM_INT);
        $req->bindParam(':premium', $premium, PDO::PARAM_BOOL);
        $req->execute();
    }

    public function isPremium(int $id_user): bool {
        $req = $this->getDb()->prepare("SELECT premium FROM user WHERE id_user = ?");
        $req->execute([$id_user]);
        return (bool) $req->fetchColumn();
    }

    public function fetchCartData($id_user) {
        // Fetch cart data from the database
        $req = $this->getDb()->prepare(
            "SELECT id_manga, id_volume FROM reservation WHERE id_user = :id_user"
        );
        $req->bindParam(":id_user", $id_user, PDO::PARAM_INT);
        $req->execute();

        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buyPremium(int $id_user) {
        $req = $this->getDb()->prepare("UPDATE user SET premium = 1 WHERE id_user = ?");
        $req->execute([$id_user]);
    }
}
