<?php
class ControllerGeneral extends Controller {
    public function __construct(AltoRouter $router) {
        parent::__construct($router);
    }
    public function contact() {
        require_once './view/contact.php';
    }

    public function kakkoii() {
        require_once './view/kakkoiimode.php';
    }

    public function page404() {
        require_once './view/page404.php';
    }
}