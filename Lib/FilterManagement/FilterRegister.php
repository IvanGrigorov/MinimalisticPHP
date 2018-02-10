<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
final class FilterRegister {
    
    const __AUTH_FILTER__ = [
        "checkIfUserIsLogged" => true,
        "checkIfUserIsAdmin" => true
    ];
    
     const __DOMAIN_FILTER__ = [
        "checkForRightDomain" => true,
    ];
} 
