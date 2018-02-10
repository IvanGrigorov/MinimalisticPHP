<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once(dirname(__FILE__)."\..\Interfaces\IView.php");

class GroundView implements IView{
    
    private $pathToViews;
    
    public function __construct() {
        $this->pathToViews = dirname(__FILE__)."\..\..\Views\\";
    }
    
    private function prepareView($viewModel) {
        extract($viewModel);
    }
    
    
    public function renderView($viewFile, $viewModel) {
        $this->prepareView($viewModel);
        ob_start();
        include($this->pathToViews.$viewFile);
        //$preparedView = ob_get_clean();
        ob_end_flush();
    }

}