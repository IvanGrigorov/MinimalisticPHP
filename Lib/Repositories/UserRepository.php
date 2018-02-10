<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once (dirname(__FILE__)."\..\Interfaces\IUserRepository.php");
require_once (dirname(__FILE__)."\..\..\Models\User.php");

class UserRepository implements IUserRepository{ 
    
    private $salt;
    private $username;
    private $password;
    
    private function getSaltForUserFromDataBase($username) {
        
    }
    
    public function returnUserFromDatabase($username) {
        // get Details from database on successfull login
        // retur example user model
        return new User($username);
    }
    
    public function deleteUserFromDatabase($username) {
        
    }
    
    public function changePasswordForUser($username) {
        
    }
    
    // Add additional methods to change the user settings
    
    
    
   
}
