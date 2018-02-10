<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once (dirname(__FILE__)."\..\URLParser.php");
require_once (dirname(__FILE__)."\..\RoutingMechanism.php");
require_once (dirname(__FILE__)."\..\Repositories\ControllerRepository.php");
require_once (dirname(__FILE__)."\..\GroundClasses\GroundView.php");




class DIContainer {
    
    private static $self = null; 
    
    private function _construct() {
    }
    
    private static function getInstance() {
        if (DIContainer::$self === null) {
            DIContainer::$self = new DIContainer();
        }
        return DIContainer::$self;
    }
    
    public static function instantiateClass($class) {
        return new $class();
    }
    
    public static function instatiateSingletonClass($class) {
        $fieldName = "_".$class;
        if (!isset(DIContainer::getInstance()->$fieldName)) {
            DIContainer::getInstance()->$fieldName = new $class();
        }
        return DIContainer::getInstance()->$fieldName;
    }
    
    public static function clearSingletonObject($class) {
        $fieldName = "_".$class;
        if (!isset(DIContainer::getInstance()->$fieldName)) {
            DIContainer::getInstance()->$fieldName = null;
            unset(DIContainer::getInstance()->$fieldName);
        }
    }
    
    public static function returnValueType() {
        
    }
}