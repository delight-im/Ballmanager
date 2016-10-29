<?php


class Route {
    
    private $action;

    public function __construct($action) {
        $this->action = $action;
    }
    
    public function run() {
        
        if(is_string($this->action)) {
            $split = explode('@', $this->action);
            $controller = new $split[0];
            $controller->$split[1]();
        } else {
            call_user_func($this->action);
        }
    }
}