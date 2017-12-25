<?php

require_once(dirname(__FILE__)."\Interfaces\IURLParser.php");

class URLParser implements IURLParser  {

    private $url;

    public function __construct() {
        //$this->url = $url;
    }
    
    function parseUrl($url) {
        $urlQuery = explode("/", $url);
        return $urlQuery;
        
    }
    
} 

?>