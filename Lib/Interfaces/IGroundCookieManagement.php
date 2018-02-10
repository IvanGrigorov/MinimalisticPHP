<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


interface IGroundCookieManagement {
    
    public function createCookie($cookieName, $value, $expire,
            $path, $domain, $secure, $httpOnly);
    public function deleteCookie($cookieName);
    public function checkIfCookieIsSet($cookieName);
    public function returnCookieValue($cookieName);
    
}

