<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


interface IGroundSessionManagement {
    
    public function createSession();
    public function checkIfSessionExist();
    public function closeSesseion();
    public function setSessionVariable($key, $value);
    public function unsetSessionVariable($key);
    public function checkIfSessionVariableIsSet($key);
    
}

