<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

interface IAuthenticationManager {     
    
    public function createToken();
    
    // The implementation of the methods is based on your approach
    // Prepared statements or PDOs
    // The database name you can get it from the config file 
    public function logIN($userName, $password);
    
    public function logOut($userName);
    
    public function signIn($userName, $password);

    
}