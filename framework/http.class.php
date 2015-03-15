<?php
/**
 * Http wrapper for curl
 * @author wherrera
 */
class Http {
    private $_url;
    private $_post;
    private $_user;
    private $_pass;
    private $_content_type;
    private $_returnHttpHeader = 0; // 1 = return http header
    
    public function Http ( $url = null ) {
        $this->_url = $url;
    }
    
    public function setUrl( $url ) {
        $this->_url = $url;
    }
    
    public function setAuth ($user, $pass) {
        $this->_user = $user;
        $this->_pass = $pass;
    }
    
    public function setContentType ($content_type) {
        $this->_content_type = $content_type;
    }
    
    public function get () {
        $p = curl_init($this->_url);
        if($p == false) {
            return false;
        }
        if( $this->_content_type != null ) {
            curl_setopt($p, CURLOPT_HTTPHEADER, array('Content-Type: ' . $this->_content_type));
        }
        curl_setopt($p, CURLOPT_HEADER, $this->_returnHttpHeader);
        if($this->_user != null && $this->_pass != null) {
            curl_setopt($p, CURLOPT_USERPWD, $this->_user . ":" . $this->_pass);
        }        
        curl_setopt($p, CURLOPT_TIMEOUT, 30);        
        if($this->_post != null) {
            curl_setopt($p, CURLOPT_POST, 1);
            curl_setopt($p, CURLOPT_POSTFIELDS, $this->_post);
        }
        curl_setopt($p, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($p);
        curl_close($p);
        return $result;
    }
    
    public static function codeToStatus ($code) {
        switch ($code) {
            case 100:return 'Continue'; 
            case 101:return 'Switching Protocols'; 
            case 200:return 'OK'; 
            case 201:return 'Created'; 
            case 202:return 'Accepted'; 
            case 203:return 'Non-Authoritative Information'; 
            case 204:return 'No Content'; 
            case 205:return 'Reset Content'; 
            case 206:return 'Partial Content'; 
            case 300:return 'Multiple Choices'; 
            case 301:return 'Moved Permanently'; 
            case 302:return 'Moved Temporarily'; 
            case 303:return 'See Other'; 
            case 304:return 'Not Modified'; 
            case 305:return 'Use Proxy'; 
            case 400:return 'Bad Request'; 
            case 401:return 'Unauthorized'; 
            case 402:return 'Payment Required'; 
            case 403:return 'Forbidden'; 
            case 404:return 'Not Found'; 
            case 405:return 'Method Not Allowed'; 
            case 406:return 'Not Acceptable'; 
            case 407:return 'Proxy Authentication Required'; 
            case 408:return 'Request Time-out'; 
            case 409:return 'Conflict'; 
            case 410:return 'Gone'; 
            case 411:return 'Length Required'; 
            case 412:return 'Precondition Failed'; 
            case 413:return 'Request Entity Too Large'; 
            case 414:return 'Request-URI Too Large'; 
            case 415:return 'Unsupported Media Type'; 
            case 500:return 'Internal Server Error'; 
            case 501:return 'Not Implemented'; 
            case 502:return 'Bad Gateway'; 
            case 503:return 'Service Unavailable'; 
            case 504:return 'Gateway Time-out'; 
            case 505:return 'HTTP Version not supported'; 
        }
    }
}