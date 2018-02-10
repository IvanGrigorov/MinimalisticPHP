<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once(dirname(__FILE__)."\..\Interfaces\IAuthenticationManager.php");
require_once(dirname(__FILE__)."\..\..\config.php");

class AuthenticationManager implements IAuthenticationManager{
    
    private $userTable;
    
    public function __construct() {
        $this->userTable = "Your user table";
    }
    
    public function createToken() {
        $charColectionForToken = "abcdefghigklmnopqrstuvwxyzABCDEFGHIGKLMNOPQRSTUVWXYZ1234567890";
        $token = "";
        for($index = 0; $index < 24; $index++) {
            $token .= $charColectionForToken[rand(0, 61)];
        }
        return $token;
    }
    
    // The implementation of the methods is based on your approach
    // Prepared statements or PDOs
    // The database name you can get it from the config file 
    public function logIN($userName, $password) {
        
    }
    
    public function logOut($userName) {
        
    }
    
    public function signIn($userName, $password) {
        
    }
    
    private function checkForSameUsername($username) {
        
    }

}