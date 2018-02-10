<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once(dirname(__FILE__)."\..\Interfaces\IGroundSessionManagement.php");


/*
 * Remember to inject this management with the DI Container
 * Best solution is with singleton principle
 */
class GroundSessionManagement implements IGroundSessionManagement  {
    
    // Remember to set the path for the session storage
    
    private $isSessionStarted = false;
    
    public function __construct() {
        
    }
    
    public function createSession() {
        $this->isSessionStarted = session_start();       
    }
    
    public function checkIfSessionExist() {
        return $this->isSessionStarted;
    }
    
    public function closeSesseion() {
        // Remember to clear all stored variables in $_SESSION
        if ($this->isSessionStarted) {
            $this->isSessionStarted = session_destroy();
        }
    }
  
    public function setSessionVariable($key, $value) {
        $_SESSION[$key] = $value;
    }
    
    public function unsetSessionVariable($key) {
        unset($_SESSION[$key]);        
    }
    
    public function checkIfSessionVariableIsSet($key) {
        return isset($_SESSION[$key]);
    }
    
}