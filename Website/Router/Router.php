<?php

class Router {
    
    protected static $_routes = array();
    
    public static function add($url, $action) {
        $route = new Route($action);
        self::$_routes[$url] = $route;
    }
    
    public static function dispatch() {
        if(isset($_SERVER['REQUEST_URI'])) {
            $split = explode('/', $_SERVER['REQUEST_URI']);
            $url = '/'.end($split);
        } else {
            $url = '/';
        }
        
        if(array_key_exists($url, self::$_routes)) {
            self::$_routes[$url]->run();
            return;
        } else {
            header('HTTP/1.0 404 Not Found');
            exit;
        }
    }
    
}