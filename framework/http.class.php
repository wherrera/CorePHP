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
        if( $this->_content_type != null ) {
            curl_setopt($p, CURLOPT_HTTPHEADER, array('Content-Type: ' . $this->_content_type));
        }
        curl_setopt($p, CURLOPT_HEADER, 1);        
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
}
?>