<?php

require_once(dirname(__FILE__)."/app.php");
require_once(dirname(__FILE__)."/config.php");
// Collect all Exception in one file
require_once(dirname(__FILE__)."\Lib\ExceptionHandlers\RouteToControllerMappingException.php");


echo phpinfo();

$app = new App();
$routing = $app->getRoutingMechanism();
$routeInfo = $routing->MatchRoute(Config::getEnv());
try {
    $app->actionInvocation($routeInfo);

} catch (RouteToControllerMappingException $ex) {
    // Redirect to static internal problem page
    echo "Yes";
}


?>