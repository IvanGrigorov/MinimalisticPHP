<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once (dirname(__FILE__)."\..\Interfaces\IControllerRepository.php");

final class ControllerRepository implements IControllerRepository{
    
    private $routeToControllersFolder;
    
    public function __construct() {
        $this->routeToControllersFolder = dirname(__FILE__)."\..\..\Controllers\\";
    }
    public function returnController($controllerName) {
        $controllerName = $controllerName."Controller";
        require_once($this->routeToControllersFolder.$controllerName.".php");
        return new $controllerName();
    }

}