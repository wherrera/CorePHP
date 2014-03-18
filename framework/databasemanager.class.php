<?php
/**
 * @author wherrera
 */
class DatabaseManager {
    private static $instance = null;
        
    private $databases = array();
    
    private function __construct() {        
    }
    
    /**
     * @return DatabaseManager
     */
    public static function getInstance() {
        if( self::$instance == null) {
            self::$instance = new DatabaseManager();
            self::$instance->init();
        }
        return self::$instance;
    }
    
    private function init () {
        foreach (Settings::$DB_CONNECTIONS as $key => $value) {
            $username   = isset($value['username']) ? $value['username'] : "";
            $password   = isset($value['password']) ? $value['password'] : "";
            $hostname   = isset($value['hostname']) ? $value['hostname'] : "";
            $dbname     = isset($value['dbname']) ? $value['dbname'] : "";            
            $this->databases[$key] = new MySQLDatabase($hostname,$username,$password,$dbname);
        }
    }
    
    /**
     * @return Database
     */
    public function getDatabase ($name = NULL) {
        $db = null;
        if($name == NULL && count($this->databases) > 0) {
            $db = current($this->databases);
        }
        else if( isset($this->databases[$name])) {
            $db = $this->databases[$name];
        }
        if($db != null && $db->connected() == false) {
            $db->connect();
        }
        return $db;
    }
}
?>