<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once (dirname(__FILE__)."\..\Interfaces\IViewRepository.php");

final class ViewRepository implements IViewRepository{
    
    private $routeToViewsFolder;
    
    public function __construct() {
        $this->routeToViewsFolder = dirname(__FILE__)."\..\..\Views\\";
    }
    public function returnView($viewName) {
        $view = $viewName;
        require_once($this->routeToViewsFolder.$view.".php");
        return new $view();
    }

}