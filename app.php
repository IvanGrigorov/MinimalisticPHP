<?php

require_once(dirname(__FILE__)."\Lib\Interfaces\IRoutingMechanism.php");
require_once(dirname(__FILE__)."\Lib\RoutingMechanism.php");
require_once(dirname(__FILE__)."\Lib\URLParser.php");
require_once(dirname(__FILE__)."\Lib\DI\DIContract.php");



final class App {

    /** @var IRoutingMechanism */
    private $routingMechanism ;


    function __construct() {
        $this->routingMechanism = DIContract::getInstance()->getInjection("IRoutingMechanism");
    }

    public function getRoutingMechanism() {
        return $this->routingMechanism;
    }
    
    public function actionInvocation($routeConfig) {
        $tmpRouteConfig = $routeConfig;
        /* 
        * Normally you have one controller for a view
        * That means, that you do not really need to inject one, because you do not have two or more possibilities
        * If you are a fan of "inject everething" instead of using a repository you can directly inject a controller
        * You need only to create a special interface for it
        * With more controllers it is getting a liitle difficult to maintain all the required files, so you can create 
        * a special file wich includes all of them and then add it to the DIContainer class
        *              
        */
        $controllerRepository = DIContract::getInstance()->getInjection("IControllerRepository");
        $controller = $controllerRepository->returnController($tmpRouteConfig['Controller']);
        unset($tmpRouteConfig["Controller"]);
        unset($routeConfig["Controller"]);
        $reflectionControllerClass = new ReflectionClass($controller);
        if ($reflectionControllerClass->hasMethod($tmpRouteConfig["Action"])) {
            $reflectionMethod = new ReflectionMethod($controller, $tmpRouteConfig["Action"]);
            unset($tmpRouteConfig["Action"]);
            unset($routeConfig["Action"]);
            $methodArgumentsArray = $reflectionMethod->getParameters();
            foreach ($tmpRouteConfig as $key => $value) {
                foreach ($methodArgumentsArray as $argument) {
                    if($key === $argument->getName()) {
                        unset($tmpRouteConfig[$key]);
                    }                
                }
            }
            if (empty($tmpRouteConfig)) {
                $reflectionMethod->invokeArgs($controller, $routeConfig);               
            }
            else {
                throw new RouteToControllerMappingException("Method with requested parameters does not exist");
            }
        }
        else {
            throw new RouteToControllerMappingException("Controller with requested method does not exist");
        }
    }

}

?>