<?php
class ControllerDashboard extends Controller {
    public function __construct(AltoRouter $router) {
        parent::__construct($router);
    }
    public function libarian() {
        require_once './view/dashboard.php';
    } 
    public function history() {
        require_once './view/loanshistory.php';
    }
}

   