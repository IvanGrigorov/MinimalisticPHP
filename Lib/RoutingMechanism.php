<?php 

require_once(dirname(__FILE__)."/Interfaces/IRoutingMechanism.php");
require_once(dirname(__FILE__)."/Interfaces/IURLParser.php");
require_once(dirname(__FILE__)."/../Config/RegexContract.php");
require_once(dirname(__FILE__)."\DI\DIContract.php");
require_once(dirname(__FILE__)."\..\Config\RequestTypesConfig.php");
require_once(dirname(__FILE__)."\ExceptionHandlers\RouteNotFoundException.php");
require_once(dirname(__FILE__)."\FilterManagement\FilterApplier.php");
require_once(dirname(__FILE__)."\FilterManagement\FilterRegister.php");





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

    private function MatchQuery($query, $matchTarget, $defaultValues, $requestType, $filterArray) {
        if ($this->__queryType !== $requestType) {
            return false;
        }
        if ($filterArray) { 
            foreach($filterArray as $key => $value) {
               if (method_exists('FilterApplier', $key)) {
                   if (FilterApplier::$key() !== $value) {
                       return false;
                   }
               }
               else {
                   throw new Exception("Filter function ".$key. " does not exist in the FilterApplier class.");
               }
            }           
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
        // Make it global to be reused
        return $urlConfig;
        
        
    }
    public function MatchRoute($appEnvironment) {
         $parsedURL = $this ->_urlParser->parseUrl($this->__request);
         $controller = $parsedURL[0];
         $method = $parsedURL[1];

         /*
          * Adding new routes with this if checks
          */
         if ($this->MatchQuery($this->__request, "/Home/Index/{id}/{test?}", null, RequestTypesConfig::__GET, FilterRegister::__DOMAIN_FILTER__)) { 
            $routeConfig = $this->MatchQuery($this->__request, "/Home/Index/{id}/{test?}", null, $this->__queryType,  FilterRegister::__DOMAIN_FILTER__);
            return $routeConfig;
         }
         
         /*
          * Default behavior after no matching route
          */
         else { 
             // For DEV throw Exception
             if ($appEnvironment === Config::__DEV__) {
                 throw new RouteNotFoundException("Route: ".$this->__request." cannot be matched !");
             }
             // Redirect to Not Found default page
             else {
                 // You can change this config with your own behavior
                 return [
                    "Controller" => "Error",
                    "Action" => "RouteNotFound"
                 ];
             }           
         }
    }
    
    public function apllyFilterForStaticFiles() {
        $splitedQuery = $this->_urlParser->parseUrl($this->__request);
        unset($splitedQuery[count($splitedQuery) - 1]);
        unset($splitedQuery[0]);
        $staticRoute = implode("/", $splitedQuery);
        foreach (Config::__staticFolders as $route) {
            if ($route === $staticRoute) {
                return true;
            }
        }
        return false;


    }
    
}

?>