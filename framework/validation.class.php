<?php
/**
 * @author wherrera
 */
class Validation {
    public static function validEmail ($email) {       
        return strlen($email) >= 5;
    }
}
?>