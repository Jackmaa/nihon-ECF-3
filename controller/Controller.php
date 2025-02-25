<?php
class Controller {
    protected $router;

    // Constructor to accept the router instance
    public function __construct(AltoRouter $router) {
        $this->router = $router;
    }
}