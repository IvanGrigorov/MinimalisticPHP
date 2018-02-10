<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// Example User Model
class User { 
    
    private $userName;
    
    public function __construct($userName) {
        $this->userName = $userName;
    }
    
    public function setUserName($newUserName) {
        $this->userName = $newUserName;
    }
    
    public function getUserName() {
        return $this->userName;
    }
    
   
}
