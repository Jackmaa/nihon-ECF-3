<?php

class ModelUser extends Model {
    public function getUser(string $email) {
        $req = $this->getDb()->prepare('SELECT `id_user`, `username`, `email`, `password` FROM `user` WHERE `email` = :email');
        $req->bindParam(':email', $email, PDO::PARAM_STR);
        $req->execute();

        $data = $req->fetch(PDO::FETCH_ASSOC);
        return $data ? new User($data) : null;
    }

    public function isConnected() {
        if ($_SESSION) {
            header('Location: /nihon');
        }
    }

    public function checkUserMail(string $email) {

        $user = $this->getDb()->prepare('SELECT `email` FROM user WHERE `email` = :email');
        $user->bindParam(':email', $email, PDO::PARAM_STR);
        $user->execute();
        $user->fetch(PDO::FETCH_ASSOC);

        if ($user->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function checkUserName(string $username) {

        $user = $this->getDb()->prepare('SELECT `username` FROM user WHERE `username` = :username');
        $user->bindParam(':username', $username, PDO::PARAM_STR);
        $user->execute();
        $user->fetch(PDO::FETCH_ASSOC);

        if ($user->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function createUser(string $username, string $email, string $password, int $token) {

        $user = $this->getDb()->prepare(
            'INSERT INTO
                `user` (`username`, `email`, `password`, `signing_date`, `token`)
            VALUES
                (:username, :email, :password, NOW(), :token)');

        $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => $this->setCost(0.250)]);
        $user->bindParam(':username', $username, PDO::PARAM_STR);
        $user->bindParam(':email', $email, PDO::PARAM_STR);
        $user->bindParam(':password', $password, PDO::PARAM_STR);
        $user->bindParam(':token', $token, PDO::PARAM_INT);
        $user->execute();
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