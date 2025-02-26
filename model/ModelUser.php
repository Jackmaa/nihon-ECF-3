<?php

class ModelUser extends Model {
    // Retrieve user details by email
    public function getUser(string $email) {
        $req = $this->getDb()->prepare('SELECT `id_user`, `username`, `email`, `password` FROM `user` WHERE `email` = :email');
        $req->bindParam(':email', $email, PDO::PARAM_STR);
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

        // $expires_at = date('Y-m-d H:i:s', time() + 900);

        $user = $this->getDb()->prepare(
            'INSERT INTO
                `user` (`username`, `email`, `password`, `signing_date`)
            VALUES
                (:username, :email, :password, NOW())');

        $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => $this->setCost(0.250)]);
        $user->bindParam(':username', $username, PDO::PARAM_STR);
        $user->bindParam(':email', $email, PDO::PARAM_STR);
        $user->bindParam(':password', $password, PDO::PARAM_STR);
        $user->execute();
    }

    public function createTempUser(string $username, string $email, string $password, string $token){
        $expiryTime = time() + (15 * 60);
        $user = $this->getDb()->prepare('INSERT INTO `email_verify` (`username`, `email`, `password`, `expires_at`, `token`) VALUES (:username, :email, :password, :expires_at, :token)');
        $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => $this->setCost(0.250)]);
        $user->bindParam(':username', $username, PDO::PARAM_STR);
        $user->bindParam(':email', $email, PDO::PARAM_STR);
        $user->bindParam(':password', $password, PDO::PARAM_STR);
        $user->bindParam(':expires_at', $expiryTime, PDO::PARAM_STR);
        $user->bindParam(':token', $token, PDO::PARAM_STR);
        $user->execute();

    }

    public function verifyToken(string $token, string $email){
        $req = $this->getDb()->prepare('SELECT `username`, `email`, `password`, `expires_at` FROM `email_verify` WHERE `token` = ? AND `email`  = ?');
        $req->execute([$token, $email]);
        $user = $req->fetch(PDO::FETCH_ASSOC);

        if($user['expires_at'] > time()){
            $req = $this->getDb()->prepare('DELETE FROM `email_verify` WHERE `email` = :email');
            $req->bindParam(':email', $email, PDO::PARAM_STR);
            $req->execute();

            return $user;
        } else {
            return false;
        }
    }
}