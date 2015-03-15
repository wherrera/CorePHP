<?php
require_once 'config/settings.php';
require_once 'config/routing.php';
require_once 'framework/core.class.php';
$path = Settings::pathInfo();
$pathInfo = explode('/', trim($path,'/') );
$routing = new Routing($pathInfo);
$controllerName = $routing->controllerName;
$method         = $routing->methodName;
require 'controllers/' . $controllerName . '.php';
$pathValues = explode('/', $controllerName );
$className = end($pathValues);
$class = ucfirst($className);
$controller = new $class();
if ( is_object($controller) == false ) {
    exit;
}
$controller->setRouting($routing);
$controller->handleRequest($method);