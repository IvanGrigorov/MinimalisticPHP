<?php

require_once(dirname(__FILE__)."/app.php");
echo phpinfo();

$app = new App();
$routing = $app->getRoutingMechanism();
$routeInfo = $routing->MatchRoute();
$app->actionInvocation($routeInfo);


?>