<?php
class Settings {
    public static $DB_CONNECTIONS = array(
        "mysql" => 
        array(  "username"=>"",
                "password"=>"",
                "hostname"=>"localhost",
                "dbname"=>""
             )
    );    
    const DEFAULT_TIMEZONE = 'America/Los_Angeles';
    const DEBUG = true;    
}
?>