<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once(dirname(__FILE__)."\..\Interfaces\IGroundCookieManagement.php");


/*
 * Remember to inject this management with the DI Container
 * Best solution is with singleton principle
 */
class GroundCookieManagement implements IGroundCookieManagement  {
    
    // Remember to set the path for the session storage
    
    
    public function __construct() {
        
    }
    
    // TO override this method and not use the full list of parameters 
    // you can simply create new custom management class to extend this one
    // and create your own function to crate a cookie
    
    public function createCookie( $cookieName, $value, $expire,
            $path, $domain, $secure, $httpOnly) { 
        setcookie($cookieName, $value, $expire, $path, $domain, $secure, $httpOnly);        
    } 
    
    public function deleteCookie($cookieName) {
        setcookie($cookieName, null, time() - 1000); 
        unset($_COOKIE[$cookieName]);
    }
    
    public function checkIfCookieIsSet($cookieName) {
        return isset($_COOKIE[$cookieName]);
    }
    
    public function returnCookieValue($cookieName) {
        return $_COOKIE[$cookieName];
    }
    
}