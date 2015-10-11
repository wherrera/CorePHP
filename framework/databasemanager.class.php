<?php
/**
 * @author wherrera
 */
class DatabaseManager {
        
    private static $databases = null;
    
    private function DatabaseManager() {        
    }
        
    private static function init () {
        if( self::$databases == null ) {
            self::$databases = array();
            foreach (Settings::$DB_CONNECTIONS as $key => $value) {
                $username   = isset($value['username']) ? $value['username'] : "";
                $password   = isset($value['password']) ? $value['password'] : "";
                $hostname   = isset($value['hostname']) ? $value['hostname'] : "";
                $dbname     = isset($value['dbname']) ? $value['dbname'] : "";            
                self::$databases[$key] = new MySQLDatabase($hostname,$username,$password,$dbname);
            }
        }
    }
    
    /**
     * @return MySQLDatabase
     */
    public static function getDatabase ($name = NULL) {
        self::init();
        $db = null;
        if($name == NULL && count(self::$databases) > 0) {
            $db = current(self::$databases);
        }
        else if( isset(self::$databases[$name])) {
            $db = self::$databases[$name];
        }
        if($db != null && $db->connected() == false) {
            $db->connect();
        }
        return $db;
    }
}