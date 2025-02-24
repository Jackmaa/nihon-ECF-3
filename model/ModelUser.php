<?php

class ModelUser extends Model {
    public function getUser(string $email){
        $req = $this->getDb()->prepare('SELECT `id_user`, `name`, `email`, `password` FROM `user` WHERE `email` = :email');
        $req->bindParam(':email', $email, PDO::PARAM_STR);
        $req->execute();

        $data = $user->fetch(PDO::FETCH_ASSOC);
        return $data ? new User($data) : null;
    }

    public function isConnected(){
        if($_SESSION){
            header('Location: /nihon');
        }
    }

    
}