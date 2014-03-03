<?php
require_once 'config/settings.php';
require_once 'config/routing.php';
if(Settings::DEBUG) {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
}
require_once 'framework/core.class.php';
if( isset($_SERVER['PATH_INFO']) ) 
{
    $path = $_SERVER['PATH_INFO'];
}
else if( isset($_SERVER['REDIRECT_URL']) ) 
{
    $path = $_SERVER['REDIRECT_URL'];
}
else {
    $path = "";
}
$pathInfo = explode('/', trim($path,'/') );
$routing = new Routing($pathInfo);
$controllerName = $routing->controllerName;
$method         = $routing->methodName;
require 'controllers/' . $controllerName . '.php';
$pathValues = explode('/', $controllerName );
$className = end($pathValues);
$class = ucfirst( $className );
$controller = new $class();
if ( is_object($controller) == false ) {
    exit;
}
$controller->setRouting($routing);
$controller->handleRequest($method);
?>