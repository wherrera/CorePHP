<?php
/**
 * @author wherrera
 */
class FormsAuthentication extends Authentication {
    private $_roles = array();
    private $_authenticated = false;
    private $_username = 'GUEST';
    private $_database = null;
    private $_loginView;
    private $_datasource;
    private $_controller;
    
    public function FormsAuthentication ( MySQLDatabase $database,
                                          Controller $controller,
                                          $login_view = false ) {
        $this->_database    = $database;
        $this->_loginView   = $login_view;
        $this->_datasource  = $_REQUEST;
        $this->_controller  = $controller;
        
        $user = Session::GetJsonObject('user');
        if($user != false) {
            $this->_username = $user->username;
            $this->_authenticated = true;
        }
    }
    
    public function AuthenticationType() {
        return 'Forms Authentication';
    }

    public function HasRole($role) {
        return isset( $this->_roles[$role] );
    }

    public function IsAuthenticated() {
        return $this->_authenticated;
    }

    public function SignOut() {
        $this->_authenticated = false;
        $this->_roles = array();
    }

    public function UserName() {
        return $this->_username;
    }

    public function Authenticate() {
        if($this->IsAuthenticated()) {
            return true;
        }
        $username = isset( $this->_datasource['username'] ) ? $this->_datasource['username'] : false;
        $password = isset( $this->_datasource['password'] ) ? md5( $this->_datasource['password'] ) : false;
                
        if( !$username && !$password ) {
            $this->_controller->loadview($this->_loginView);
            return false;
        } 
                
        $result = $this->_database->query(  'select * from ' . Settings::$USERS['table'] . 
                                            ' where ' . Settings::$USERS['username.column'] . '="' . $username . '"' .
                                            ' and ' . Settings::$USERS['password.column'] . '="' . $password . '"');
        if( $result == false ) {
            $this->_controller->loadview($this->_loginView, array('error' => 'invalid username/password'));
            return false;
        }
        $user = $this->_database->fetchAssoc($result);
        if($user == false) {
            $this->_controller->loadview($this->_loginView, array('error' => 'invalid username/password'));
            return false;
        }
        $this->_username = $user[Settings::$USERS['username.column']];
        $this->_authenticated = true;
        Session::Set('user', json_encode($user) );
        return true;
    }

    public function ViewRedirect() {
        return $this->_loginView;
    }
}