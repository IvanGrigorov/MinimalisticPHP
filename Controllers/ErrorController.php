<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once (dirname(__FILE__)."\..\Lib\Interfaces\IController.php");

class ErrorController implements IController{
    
    public function createView() {
        echo "Test";
    }
    
    public function RouteNotFound() {
        echo ("Run");
    } 

}