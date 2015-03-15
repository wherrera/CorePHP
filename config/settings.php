<?php
class Settings {
    public static $DB_CONNECTIONS = array(
        "mysql" => 
        array(  "username"=>"root",
                "password"=>"root",
                "hostname"=>"localhost",
                "dbname"=>"corephp"
             )
    );
    public static $USERS = array (
        'table' => 'users',
        'id.column' => 'id',
        'username.column' => 'username',
        'password.column' => 'password',
        'hash.algorithm' => 'MD5'
    );
    const DEFAULT_TIMEZONE = 'America/Los_Angeles';
    const DEBUG = false;
    public static function pathInfo () {
        $path = "";
        if( isset($_SERVER['PATH_INFO']) ) 
        {
            $path = filter_input(INPUT_SERVER, 'PATH_INFO');
        }
        else if( isset($_SERVER['REDIRECT_URL']) ) 
        {
            $path = filter_input(INPUT_SERVER,'REDIRECT_URL');
        }
        return $path;
    }
}

if(Settings::DEBUG) {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
}