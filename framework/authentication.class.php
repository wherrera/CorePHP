<?php
/**
 * @author wherrera
 */
abstract class Authentication {    
    /**
     * @return: bool
     */
    abstract public function IsAuthenticated ();
    
    /**
     * @return: bool
     */
    abstract public function SignOut ();
    
    /**
     * @return: string
     */
    abstract public function UserName ();
    
    /**
     * @return: string
     */
    abstract public function AuthenticationType ();
    
    /**
     * Example HasRole("admin")
     * @return: bool
     */
    abstract public function HasRole ($role);
    
    /**
     * Authenticate
     * @return: bool
     */
    abstract public function Authenticate ();
    
    /**
     * View Redirect
     * @return: View
     */
    abstract public function ViewRedirect ();
}