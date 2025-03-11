<?php
session_start();
require_once './vendor/autoload.php';
require_once './vendor/altorouter/altorouter/AltoRouter.php';
require_once './config.php';
$router = new AltoRouter();

//HOMEPAGE
$router->map("GET", "/", "ControllerManga#home", "home");

/*******************************||  USERS  ||**************************************/
//USER 
//LOGIN
$router->map("GET|POST", "/login", "ControllerUser#login", "login");
//LOGOUT
$router->map("GET", "/logout", "ControllerUser#logout", "logout");
//REGISTER
$router->map("GET|POST", "/register", "ControllerUser#register", "register");
//VERIFY
$router->map("GET", "/verify/*", "ControllerUser#verify", "verify");
$router->map("GET|POST", "/finishsignup/*", "ControllerUser#verifyUser", "verifyUser");
//UPDATE
$router->map("GET|POST", "/updateUser/[i:id]", "ControllerUser#update", "updateUser");
//MY PROFILE
$router->map("GET", "/myProfile/[i:id]", "ControllerUser#myProfile", "myProfile");

//CURRENT STORIES
$router->map("GET", "/currentStorie", "ControllerUser#currentStorie", "currentStorie");

// PAST CHRONICLES
$router->map("GET", "/pastChronicle", "ControllerUser#pastChronicle", "pastChronicle");

// FAVORITE
$router->map('GET', "/favorite", 'ControllerUser#favoriteManga', 'favoriteManga');

/*******************************||  CART  ||**************************************/
$router->map("GET", "/cart", "CartController#cart", "cart");
$router->map('GET|POST', '/cart/add', 'CartController#add', 'cart_add');
$router->map('GET|POST', '/cart/remove', 'CartController#remove', 'cart_remove');
$router->map('POST', '/cart/confirm', 'CartController#confirmBorrow', 'cart_confirm');
$router->map('POST', '/cart/clear', 'CartController#clearCart', 'clearCart');

/*******************************||  MANGAS  ||**************************************/
//MANGA
//SEARCH
$router->map("GET|POST", "/search", "ControllerManga#search", "search");
//CREATE
$router->map("GET|POST", "/create", "ControllerManga#create", "create");
$router->map("GET|POST", "/authorAJAX", "ControllerManga#authorAJAX", "authorAJAX");
//LIKE
$router->map('POST', '/like', 'ControllerManga#likeManga', 'like_manga');
$router->map("POST", "/getLikedMangas", "ControllerManga#getUserLikedMangas", "like_user");
//READ
$router->map("GET|POST", "/manga/[i:id]", "ControllerManga#read", "read");
//UPDATE MANGA
$router->map("GET|POST", "/update/[i:id]", "ControllerManga#update", "update");
//CONTACT
$router->map("GET|POST", "/contact", "ControllerGeneral#contact", "contact");

//KAKKOII MODe
$router->map("GET", "/kakkoii", "ControllerGeneral#kakkoii", "kakkoii");

//DELETE MANGA
$router->map("GET", "/delete/[i:id]", "ControllerManga#delete", "delete");

// CATEGORY
$router->map("GET", "/category", "ControllerManga#readCategory", "readCategory");

/*******************************||  AUTHORS  ||**************************************/
//AUTHOR
//READ
$router->map("GET", "/author/[i:id]", "ControllerManga#readAuthor", "readAuthor");

/*******************************||  ADMIN  ||**************************************/
//LOGIN
$router->map("GET|POST", "/dashboard-access", "ControllerAdmin#login", "admin_login");
//DASHBOARD
$router->map("GET", "/dashboard", "ControllerAdmin#dashboard", "admin_dashboard");
//SEARCH MANGA
$router->map("GET|POST", "/searchManga", "ControllerAdmin#searchManga", "searchManga");
//SEARCH USER
$router->map("GET|POST", "/searchUser", "ControllerAdmin#searchUser", "searchUser");
//CREATE USER
$router->map("GET|POST", "/createUser", "ControllerAdmin#createUser", "createUser");

/*******************************||  BORROW/RETURNS  ||**************************************/
//BOOKGestion
$router->map('POST', '/borrow', 'BorrowController#borrow', 'borrow');
$router->map('POST', '/return', 'BorrowController#returnManga', 'returnManga');

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
}
