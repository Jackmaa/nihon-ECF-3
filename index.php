<?php
session_start();
require_once './vendor/autoload.php';
require_once './vendor/altorouter/altorouter/AltoRouter.php';

$router = new AltoRouter();
$router->setBasePath('/nihon');

//HOMEPAGE
$router->map("GET", "/", "ControllerManga#home", "home");

//LOGIN
$router->map("GET|POST", "/login", "ControllerUser#login", "login");

//REGISTER
$router->map("GET|POST", "/register", "ControllerUser#register", "register");

$match = $router->match();



if(is_array($match)){
    list($controller, $action) = explode('#', $match['target']);
    $obj = new $controller($router);

    if(is_callable(array($obj, $action))){
        call_user_func_array(array($obj, $action), $match['params']);
    }
    else{
        echo "Error: can't call $action on $controller";
    }
}