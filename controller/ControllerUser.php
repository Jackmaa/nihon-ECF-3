<?php

class ControllerUser {

    private function login(){
        $model = new ModelUser();
        $model ->isConnected();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!empty($_POST['mail']) && !empty($_POST['password'])){
                $user = $model->getUser($_POST['mail']);
                if($user && password_verify($_POST['password'], $user->getPassword())){
                    $_SESSION['id'] = $user->getId_user();
                    $_SESSION['name'] = $user->getName();
                    header('Location: /nihon');
                    exit();
                } else {
                    $error = 'email or password is not valid';
                    require_once('./view/login.php');
                }
            } else {
                $error = 'Fields are incorrect';
                require_once('./view/login.php');
            }
        } else {
            require_once('./view/login.php');
        }
    }

    public function logout(){
        session_unset();
        session_destroy();
        header('Location: /nihon');
    }

}