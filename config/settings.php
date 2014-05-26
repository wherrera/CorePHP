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
    const DEBUG = true;    
}
?>