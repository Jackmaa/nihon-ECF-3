<?php
class ControllerDashboard {
    public function libarian() {
        require_once './view/dashboard.php';
    } 
    public function history() {
        require_once './view/loanshistory.php';
    }
}

   