<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once (dirname(__FILE__)."\..\Interfaces\IURLParser.php");
require_once (dirname(__FILE__)."\..\Interfaces\IRoutingMechanism.php");
require_once (dirname(__FILE__)."\..\Interfaces\IControllerRepository.php");
require_once (dirname(__FILE__)."\..\Interfaces\IView.php");
require_once (dirname(__FILE__)."\DIContainer.php");

class DIContract {
    
    private static $self = null;
    private $mappedObject = array();
    
    private function _construct() {
        
    }
    public static function getInstance() {
        if (DIContract::$self === null) {
            DIContract::$self = new DIContract();
            DIContract::$self->mapInstances();
        }
        return DIContract::$self;
    }
    
    private function mapInstances() {
        DIContract::$self->mappedObject["_URLParser"] = [
            "className" => "URLParser",
            "isSingleton" => true
        ];
        DIContract::$self->mappedObject["_RoutingMechanism"] = [
            "className" => "RoutingMechanism",
            "isSingleton" => true
        ];
        DIContract::$self->mappedObject["_ControllerRepository"] = [
            "className" => "ControllerRepository",
            "isSingleton" => true
        ];
        DIContract::$self->mappedObject["_View"] = [
            "className" => "GroundView",
            "isSingleton" => true
        ];
            
    
        //DIContract::$self->_URLParser = DIContainer::instatiateSingletonClass("URLParser");
        //DIContract::$self->_RoutingMechanism = DIContainer::instatiateSingletonClass("RoutingMechanism");
        //DIContract::$self->_ControllerRepository = DIContainer::instatiateSingletonClass("ControllerRepository");


    } 
    
    public function getInjection($interface) {
        if (!interface_exists($interface)) {
            throw new Exception($interface . " is not declared in the required stack");
        }
        else {
            $replacesCount = 1;
            $className = str_replace("I", "_", $interface, $replacesCount);
            if (!isset(DIContract::$self->mappedObject[$className])) {
                throw new Exception("GIven Inteface: ". $interface. " and extracted field name does not match the ones in the mapped Instances");
            }
            
            $instanceToInject = null;
            if (DIContract::$self->mappedObject[$className]["isSingleton"]) {
                $instanceToInject = DIContainer::instatiateSingletonClass(DIContract::$self->mappedObject[$className]["className"]);
            }            
            else {
                $instanceToInject = DIContainer::instantiateClass(DIContract::$self->mappedObject[$className]["className"]);
            } 
            if (!$instanceToInject instanceof $interface) {
                throw new Exception("Mapped class do not inherits the given Inteface: ". $interface);
            }
            return $instanceToInject;
        }
    }
}
