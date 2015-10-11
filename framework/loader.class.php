<?php
/**
 * CorePHP
 * @author wherrera
 */
function loadControllerConfig() {
    $config = json_decode( file_get_contents('settings/controllers.json') )->controllers;
    $controllers = array();
    foreach ($config as $key => $value) {
        $controllers[$key] = $value;
    }
    return $controllers;
}

function loadController ($name, $methodName = 'execute') {
    $controlers = loadControllerConfig();
    if( isset($controlers[$name]) ) {
        //require $controlers[$name];
        $class = ucfirst($name);
        $controller = new $class();
        if ( is_object($controller) == false ) {
            throw new InvalidControllerException($class);
        }
        $controller->handleRequest($methodName);
    } else {
        throw new InvalidControllerException($name);
    }
}

function handle_request() {
    $path = "";
    if( isset($_SERVER['PATH_INFO']) ) {
        $path = filter_input(INPUT_SERVER, 'PATH_INFO');
    }
    else if( isset($_SERVER['REDIRECT_URL']) ) {
        $path = filter_input(INPUT_SERVER,'REDIRECT_URL');
    }
    $pathInfo = explode('/', trim($path,'/') );
    $controllerName = (count($pathInfo) > 0) ? $pathInfo[0] : "index";
    $methodName = (count($pathInfo) > 1) ? $pathInfo[1] : "execute";   
    if(strlen($controllerName) > 0) {
        loadController($controllerName, $methodName);
    } else {
        loadController('index');
    }    
}