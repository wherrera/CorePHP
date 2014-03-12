<?php
/**
 * @author wherrera
 */
class DateUtility {
    public static function getPrevDate($mysqlDateTime) {
        
        $phpdate = strtotime( $mysqlDateTime );
        
        $tm = -1 * ($phpdate - time());
        
        if($tm < 0) {
            return "";
        } 
        else if( $tm <= 60 ) {
            return 'about a minute ago';
        } 
        else if( $tm <= 3600 ) {
            return ' ' . round($tm / 60) . ' minutes ago';
        }
        else if( $tm <= 86400 ) {
            return ' ' . round($tm / 3600) . ' hours ago';
        }
        else
        {
            return ' ' . round($tm / 86400) . ' days ago';
        }
    }
    public static function getDateUntilString($mysqlDateTime) {
        
        $phpdate = strtotime( $mysqlDateTime );
        
        $tm = $phpdate - time();
        
        if($tm < 0) {
            return "";
        } 
        else if( $tm <= 60 ) {
            return 'about a minute';
        } 
        else if( $tm <= 3600 ) {
            return 'about ' . round($tm / 60) . ' minutes';
        }
        else if( $tm <= 86400 ) {
            return 'about ' . round($tm / 3600) . ' hours';
        }
        else 
        {
            return 'about ' . round($tm / 86400) . ' days';
        }
    }
    public static function getPrevTimeString($timestamp) {
        
        $tm = (time() - $timestamp);
        
        if( $tm < 60 ) {
            return 'less than a minute ago';
        } 
        else if( $tm >= 60 && $tm < 120 ) {
            return 'about a minute ago';
        } 
        else if( $tm <= 3600 ) {
            return ' ' . round($tm / 60) . ' minutes ago';
        }
        else if( $tm <= 86400 ) {
            return ' ' . round($tm / 3600) . ' hours ago';
        }
        else {
            return ' ' . round($tm / 86400) . ' days ago';
        }
    }
}
?>