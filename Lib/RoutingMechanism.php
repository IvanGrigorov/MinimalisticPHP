<?php 

require_once(dirname(__FILE__)."/Interfaces/IRoutingMechanism.php");
require_once(dirname(__FILE__)."/Interfaces/IURLParser.php");
require_once(dirname(__FILE__)."/../Config/RegexContract.php");
require_once(dirname(__FILE__)."\DI\DIContract.php");
require_once(dirname(__FILE__)."\..\Config\RequestTypesConfig.php");



class RoutingMechanism implements IRoutingMechanism {

    private $__queryType;
    private $__url; 
    private $__request;
    /** @var IURLParser */
    private $_urlParser;
    
    public function __construct() {
        $this->__queryType = $_SERVER["REQUEST_METHOD"];
        $this->__url = $_SERVER["SERVER_NAME"]."/".$_SERVER["REQUEST_URI"];
        $this->__request = $_SERVER["REQUEST_URI"];
        $this->_urlParser = DIContract::getInstance()->getInjection("IURLParser");
    }

    //private function GetQueryTypeFormUrl() {
        
    //}

    public function GetQueryType() {
        return $this->__queryType;
    }

    private function MatchRouteQuery($parsedQuery, $match, $defaults) {
        $urlConstruct = [];
        preg_match(RegexContract::CONTROLLER_METHOD_PARSER, $match, $matches);
        if (empty($matches[2])) {
            if (empty($defaults["Controller"])) {
                throw new Eception("Not Accepted route");
            }
            else $urlConstruct["Controller"] = $defaults["Controller"];
        }
        else {
            $urlConstruct["Controller"] = $parsedQuery[0];
        }
        if (empty($matches[3])) {
            if (empty($defaults["Action"])) {
                throw new Eception("Not Accepted route");
            }
            else $urlConstruct["Action"] = $defaults["Action"];
        }
        else {
            $urlConstruct["Action"] = $parsedQuery[1];
        }
        preg_replace(RegexContract::CONTROLLER_METHOD_PARSER, "", $match);
        //preg_match_all(RegexContract::QUERY_PARSER, $match, $queryMatches);
        for ($index = 2; $index < count($parsedQuery); $index++) {
            if (preg_match(RegexContract::QUERY_PARSER, $parsedQuery[$index])) {
                
                //Clean Value 
                str_replace("}", "", $parsedQuery[$index]);
                str_replace("{", "", $parsedQuery[$index]);

                $urlConstruct[$parsedQuery[$index]] = $parsedQuery[$index];
            }
        }

    }

    private function MatchQuery($query, $matchTarget, $defaultValues, $requestType) {
        if ($this->__queryType !== $requestType) {
            return false;
        }
        $urlConfig = [];
        $splitedQuery = $this->_urlParser->parseUrl($query);
        $splitedTargetMatch = $this->_urlParser->parseUrl($matchTarget); 
        // The first part must allways be a constructor name
        // The second part must allawys be the action name
        if (preg_match(RegexContract::OPTIONAL_QUERY_PARAMETERS, $splitedQuery[1])) {
            if ($splitedQuery[1] !== $splitedTargetMatch[1]) {
                if (!empty($defaultValues["Controller"])) {
                    $urlConfig["Controller"] = $defaultValues["Controller"];
                }
                else {
                    // This match target does not match the query
                    return false;
                }
            }
            else {
                $urlConfig["Controller"] = $splitedTargetMatch[1];
            }
        }
        else if ($splitedQuery[1] === $splitedTargetMatch[1]) {
            $urlConfig["Controller"] = $splitedTargetMatch[1];
            
        }
        else {
            return false;
            
        }
        if (preg_match(RegexContract::OPTIONAL_QUERY_PARAMETERS, $splitedQuery[2])) {
            if ($splitedQuery[2] !== $splitedTargetMatch[2]) {
                if (!empty($defaultValues["Action"])) {
                    $urlConfig["Action"] = $defaultValues["Action"];
                }
                else {
                    // This match target does not match the query
                    return false;
                }
            }
            else {
                $urlConfig["Action"] = $splitedTargetMatch[2];
            }
        }
        else if ($splitedQuery[2] === $splitedTargetMatch[2]) {
            $urlConfig["Action"] = $splitedTargetMatch[2];
            
        }
        else {
            return false;
            
        }
        // Working with the parameters 
        for ($index = 3; $index < count($splitedTargetMatch); $index++) {
            if (preg_match(RegexContract::QUERY_PARSER, $splitedTargetMatch[$index])) {
                // Last parameter can be optional
                if ($index === count($splitedTargetMatch) - 1) {
                    if (preg_match(RegexContract::OPTIONAL_QUERY_PARAMETERS, $splitedTargetMatch[$index])) {
                                               
                        if ((count($splitedQuery) === count($splitedTargetMatch) -1 )) {
                            $splitedTargetMatch[$index] = str_replace("{", "", $splitedTargetMatch[$index]);
                            $splitedTargetMatch[$index] = str_replace("}", "", $splitedTargetMatch[$index]);                            
                            if (!empty($defaults[$splitedTargetMatch[$index]])) {
                                $splitedTargetMatch[$index] = str_replace("{", "", $splitedTargetMatch[$index]);
                                $splitedTargetMatch[$index] = str_replace("}", "", $splitedTargetMatch[$index]); 
                                $splitedTargetMatch[$index] = str_replace("?", "", $splitedTargetMatch[$index]);  
                                $urlConfig[$splitedTargetMatch[$index]] = $defaults[$splitedTargetMatch[$index]];
                            }
                            else {
                                return false;
                            }
                        }
                    
                        else { 
                            $splitedTargetMatch[$index] = str_replace("{", "", $splitedTargetMatch[$index]);
                            $splitedTargetMatch[$index] = str_replace("}", "", $splitedTargetMatch[$index]); 
                            $splitedTargetMatch[$index] = str_replace("?", "", $splitedTargetMatch[$index]);                            
                            $urlConfig[$splitedTargetMatch[$index]] = $splitedQuery[$index];
                        }
                    }
                    else {
                    $splitedTargetMatch[$index] = str_replace("{", "", $splitedTargetMatch[$index]);
                    $splitedTargetMatch[$index] = str_replace("}", "", $splitedTargetMatch[$index]);                            
                    $urlConfig[$splitedTargetMatch[$index]] = $splitedQuery[$index];
                    }
                }  
                else { 
                    $splitedTargetMatch[$index] = str_replace("{", "", $splitedTargetMatch[$index]);
                    $splitedTargetMatch[$index] = str_replace("}", "", $splitedTargetMatch[$index]);                            
                    $urlConfig[$splitedTargetMatch[$index]] = $splitedQuery[$index];
                }  
            }
            else {
                if ($splitedTargetMatch[$index] === $splitedQuery[$index]) {
                    return false;
                }
            }
        }
        return $urlConfig;
        
        
    }
    public function MatchRoute() {
         $parsedURL = $this ->_urlParser->parseUrl($this->__request);
         $controller = $parsedURL[0];
         $method = $parsedURL[1];         

         if ($this->MatchQuery($this->__request, "/Home/Index/{id}/{test?}", null, RequestTypesConfig::__GET)) { 
            $routeConfig = $this->MatchQuery($this->__request, "/Home/Index/{id}/{test?}", null, $this->__queryType);
            //$controllerRepository = DIContract::getInstance()->getInjection("IControllerRepository");
            //$controller = $controllerRepository->returnController($routeConfig['Controller']);
            //$controller->createView();
            return $routeConfig;
            /* 
             * Normally you have one controller for a view
             * That means, that you do not really need to inject one, because you do not have two or more possibilities
             * If you are a fan of "inject everething" instead of using a repository you can directly inject a controller
             * You need only to create a special interface for it
             * With more controllers it is getting a liitle difficult to maintain all the required files, so you can create 
             * a special file wich includes all of them and then add it to the DIContainer class
             *              
             */
             //return $this->MatchQuery($this->__request, "/Home/Index/{id?}/{test?}", null);

         }
         //$this->__request == "Home/Index/id?/test?") 
    }
    
}

?>