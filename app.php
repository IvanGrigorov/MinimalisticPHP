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
        $controllerRepository = DIContract::getInstance()->getInjection("IControllerRepository");
        $controller = $controllerRepository->returnController($tmpRouteConfig['Controller']);
        unset($tmpRouteConfig["Controller"]);
        $reflectionControllerClass = new ReflectionClass($controller);
        if ($reflectionControllerClass->hasMethod($tmpRouteConfig["Action"])) {
            $reflectionMethod = new ReflectionMethod($controller, $tmpRouteConfig["Action"]);
            unset($tmpRouteConfig["Action"]);
            $methodArgumentsArray = $reflectionMethod->getParameters();
            foreach ($tmpRouteConfig as $key => $value) {
                foreach ($methodArgumentsArray as $argument) {
                    if($key === $argument->getName()) {
                        unset($tmpRouteConfig[$key]);
                    }                
                }
            }
            if (empty($tmpRouteConfig)) {
                echo "Yes";
            }

        }
    }

}

?>