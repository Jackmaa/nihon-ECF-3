<?php
session_start();
require_once './vendor/autoload.php';
require_once './vendor/altorouter/altorouter/AltoRouter.php';

$router = new AltoRouter();

//HOMEPAGE
$router->map("GET", "/", "ControllerManga#home", "home");

//USER 
//LOGIN
$router->map("GET|POST", "/login", "ControllerUser#login", "login");

//REGISTER
$router->map("GET|POST", "/register", "ControllerUser#register", "register");

//VERIFY
$router->map("GET", "/verify/*", "ControllerUser#verify", "verify");

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
// Match the current request
$match = $router->match();

// Debugging: Output the matched route
// var_dump($match);

if (is_array($match)) {
    // Extract controller and action from the matched route
    list($controller, $action) = explode('#', $match['target']);

    // Check if the controller class exists
    if (class_exists($controller)) {
        $obj = new $controller($router);

        // Check if the action method is callable
        if (is_callable([$obj, $action])) {
            // Call the action method with parameters
            call_user_func_array([$obj, $action], $match['params']);
        } else {
            // Error: Action method not found
            echo "Error: Action '$action' not found in controller '$controller'.";
        }
    } else {
        // Error: Controller class not found
        echo "Error: Controller '$controller' not found.";
    }
} else {
    // Error: No route matched
    echo "Error: No route matched.";
}}