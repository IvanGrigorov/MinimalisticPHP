<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once (dirname(__FILE__)."\..\Lib\Interfaces\IController.php");
require_once (dirname(__FILE__)."\..\ViewModels\TestModel.php");

class HomeController implements IController{
    
    public function createView() {
        echo "Test";
    }
    
    public function Index($id, $test) {
        $view = DIContract::getInstance()->getInjection("IView");
        // Create View Model
        $someViewModel =  new TestModel();
        $view->renderView("home.php", array(
            "model" => $someViewModel
        ));
    } 

}