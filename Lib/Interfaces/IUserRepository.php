<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

interface IUserRepository {
    
    public function returnUserFromDatabase($username);
    
    public function deleteUserFromDatabase($username);
    
    public function changePasswordForUser($username);
    
    // Add additional methods to change the user settings

}