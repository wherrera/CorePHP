<?php
/**
 * @author wherrera
 */
class Controller {   
    /**
     * @return Database
     */
    public function getDatabase($name = NULL) {
        return DatabaseManager::getInstance()->getDatabase($name);
    }
    public function loadview($name,$args = array()) {
      $path = 'views/' . $name . '.php';
      if(file_exists($path) == false) {
          echo ('failed to load view @ ' . $path);
      }
      if(count($args) > 0) {
          extract($args);
      }
      require_once $path;
    }
    public function error ($errorCode, $errorMessage) {
      return;
    }
    public function requireArg ( $name ) {
        if ( isset ($_REQUEST[$name]) == false ) {
            $this->error(-1, 'missing argument ' . $name);
        }
        return $this->getArg($name);
    }
    public function getArg($name) {
        if(isset($_REQUEST[$name]) == false){
            return null;
        }
        return Core::getDatabase()->real_escape_string($_REQUEST[$name]);
    }
    public function handleRequest ($methodName) 
    {
        $reflect = new ReflectionClass($this);

        $methods = $reflect->getMethods(ReflectionMethod::IS_PUBLIC);

        foreach ($methods as $method) 
        {
            if ( strcmp($method->name,$methodName) == 0 ) 
            {
                $parameters = $method->getParameters();    
                $params = array();
                foreach ($parameters as $param) {        
                    $params[] = $this->getArg($param->name);                    
                }
                $method->invokeArgs($this,$params);                
                return;                
            }
        }
        $this->execute();
    }
}
?>