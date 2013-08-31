<?php
define('DEFAULT_CONTROLLER','index');
define('DEFAULT_METHOD','execute');
require_once 'config/settings.php';
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
$controllerName = DEFAULT_CONTROLLER;  // default controller
$method         = DEFAULT_METHOD;// default method
$pathInfo = explode('/', trim($path,'/') );
if(count($pathInfo) > 0) {
    $controllerName = $pathInfo[0];
}
if(count($pathInfo) > 1) {
    $method = $pathInfo[1];
}
if ( ! file_exists( 'controllers/' . $controllerName . '.php') ) {
    $controllerName = DEFAULT_CONTROLLER;
}
require 'controllers/' . $controllerName . '.php';
$pathValues = explode('/', $controllerName );
$className = end($pathValues);
$class = ucfirst( $className );
$controller = new $class();
if ( is_object($controller) == false ) {
    exit;
}
$controller->handleRequest($method);
?>