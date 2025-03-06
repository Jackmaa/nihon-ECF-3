<?php
class ControllerDashboard extends Controller {
    public function __construct(AltoRouter $router) {
        parent::__construct($router);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (! isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die("Invalid CSRF Token");
            }

            $username = $_POST['username'];
            $password = $_POST['password'];
        }
    }
}