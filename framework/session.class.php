<?php
/*
 * @Author: wherrera
 */
class Session
{
    private static $_started = false;

    public static function Start ()
    {
        if(!self::$_started) {
            self::$_started = session_start();
        }
        return self::$_started;
    }
    
    public static function Destroy () {
        self::Start();
        if(self::$_started) {
            session_destroy();
            self::$_started = false;
        }
    }
    
    public static function GetJsonObject($name) {
        $json = self::Get($name);
        if($json == false) {
            return false;
        }
        return json_decode($json);
    }
    
    public static function Get($name)
    {
        Session::Start();
        return isset( $_SESSION[$name] ) ? $_SESSION[$name] : false;
    }
    
    public static function Set($name, $value)
    {
        Session::Start();
        $_SESSION[$name] = $value;
    }
}