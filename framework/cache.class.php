<?php
/**
 * @author wherrera
 */
class Cache {

    private static $init        = FALSE;
    private static $apc_enabled = FALSE;
    private static $map         = array();
    
    private static function init() {
        if(self::$init) {
            return;
        }
        self::$init = TRUE;
        self::$apc_enabled =    function_exists('apc_exists') &&
                                function_exists('apc_store') &&
                                function_exists('apc_fetch');
    }
    
    /**
     * @param string $key
     * @return mixed <b>TRUE</b> if the key exists, otherwise <b>FALSE</b>
     */
    public static function exist ($key) {
        self::init();
        if(self::$apc_enabled == FALSE) {
            return isset( self::$map[$key] );
        }
        return apc_exists($key);
    }

    public static function store ($key, $value, $ttl = 0) {
        self::init();
        if(self::$apc_enabled == FALSE) {
           self::$map[$key] = $value;
           return TRUE;
        }
        return apc_store($key, $value, $ttl);
    }
    
    public static function fetch ($key) {
        self::init();
        if(self::$apc_enabled == FALSE) {
           return self::$map[$key];
        }
        return apc_fetch($key);
    }
    
    public static function delete ($key) {
        self::init();
        if(self::$apc_enabled == FALSE) {
            if( isset(self::$map[$key]) ) {
                unset( self::$map[$key] );
            }
            return TRUE;
        }
        return apc_delete($key);
    }
}