<?php
/**
 * @author wherrera
 */
class Logger {
    
    const INFO      = 'info';
    const WARNING   = 'warning';
    const ERROR     = 'error';
    
    public $messageType;
    public $message;
    
    private function Logger ($msg, $type) {
        $this->message = $msg;
        $this->messageType = $type;
    }
    
    private static $_messages = array();
    
    public static function Info ($msg) {
        self::$_messages[] = new Logger($msg, Logger::INFO);
    }
        
    public static function Warning ($msg) {
        self::$_messages[] = new Logger($msg, Logger::WARNING);
    }

    public static function Error ($msg) {
        self::$_messages[] = new Logger($msg, Logger::ERROR);
    }

    public static function printOut () {
        foreach (self::$_messages as $message) {
            echo '<strong>' . $message->messageType . '</strong>: ' . $message->message;
        }
    }
    
    public static function Count () {
        return count( self::$_messages );
    }
}
