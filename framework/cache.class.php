<?php
/**
 * CorePHP
 * @author wherrera
 */
class Cache {

    private static $init        = FALSE;
    private static $apc_enabled = FALSE;
    private static $map         = array();
    private static $cacheFile   = 'cache/cache.json';
    
    private static function init() {
        if(self::$init) {
            return;
        }
        self::$init = TRUE;
        self::$apc_enabled =    function_exists('apc_exists') &&
                                function_exists('apc_store') &&
                                function_exists('apc_fetch');
        if( self::$apc_enabled == FALSE ) {
            self::loadCacheFile();
        }
    }
    
    private static function saveCacheFile () {
        return file_put_contents(self::$cacheFile, json_encode(self::$map));
    }
    
    private static function loadCacheFile () {
        if( file_exists(self::$cacheFile) ) {
            $file = file_get_contents(self::$cacheFile);
            if($file != FALSE) {
                $map = json_decode($file, true);
                if($map != NULL) {
                    self::$map = array_merge(self::$map, $map);
                    return TRUE;
                }
            }
        }
        return FALSE;
    }
    
    public static function setCacheFile ($path) {
        self::$cacheFile = $path;
        self::loadCacheFile();
    }
    
    /**
     * Checks if the specified key exist in the data store
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

    /**
     * Cache a variable in the data store
     * @param string $key
     * Store the variable using this name.keys are
     * cache-unique, so storing a second value with the same
     * key will overwrite the original value.
     * @param string $value
     * @param int $ttl (optional) time to live in seconds
     * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure.
     */
    public static function store ($key, $value, $ttl = 0) {
        self::init();
        if(self::$apc_enabled == FALSE) {
           self::$map[$key] = $value;
           self::saveCacheFile();
           return TRUE;
        }
        return apc_store($key, $value, $ttl);
    }
    
    /**
     * Fetch a variable from data store
     * @param string $key
     * @return mixed The stored variable or array of variables on success; <b>FALSE</b> on failure
     */
    public static function fetch ($key) {
        self::init();
        if(self::$apc_enabled == FALSE) {
           return self::$map[$key];
        }
        return apc_fetch($key);
    }
    
    /**
     * Deletes a variable from the data store
     * @param string $key
     * @return mixed <b>TRUE</b> on success or <b>FALSE</b> on failure.
     */
    public static function delete ($key) {
        self::init();
        if(self::$apc_enabled == FALSE) {
            if( isset(self::$map[$key]) ) {
                unset(self::$map[$key]);
                self::saveCacheFile();
            }
            return TRUE;
        }
        return apc_delete($key);
    }
}