<?php
define('DEFAULT_CONTROLLER','index');
define('DEFAULT_METHOD','execute');
define('DEFAULT_CONTENT_TYPE','html');

/**
 * Define how to route request using path info
 * @author wherrera
 */
class Routing {
    public $controllerName      = DEFAULT_CONTROLLER;
    public $methodName          = DEFAULT_METHOD;
    public $returnContentType   = DEFAULT_CONTENT_TYPE;
    public $pathInfo            = array();
    
    public function Routing (array $pathInfo) {
        $this->pathInfo = $pathInfo;
        if(count($pathInfo) > 0) {
            $this->controllerName = $pathInfo[0];
        }
        if ( ! file_exists( 'controllers/' . $this->controllerName . '.php') ) {
            $this->controllerName = DEFAULT_CONTROLLER;
        }
        if(count($pathInfo) > 2)
        {            
            $this->methodName = $pathInfo[1];   
            $this->returnContentType = $pathInfo[2];
        }
        else if(count($pathInfo) > 1) 
        {
            $this->methodName = $pathInfo[1];
        }       
    }
}
?>