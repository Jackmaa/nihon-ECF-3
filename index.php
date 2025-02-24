  <?php
  session_start();
  require_once './vendor/autoload.php';
  require_once './vendor/altorouter/altorouter/AltoRouter.php';

  $router = new AltoRouter();
  $router->setBasePath('/nihon');

  //HOMEPAGE
  $router->map("GET", "/", "ControllerManga#home", "home");