<?php 

final  class Config {

    const __DEV__ = "DEV";
    const __PROD__ = "PROD";   
    //private $__env = __DEV__;
    const __staticFolders = [];
    
    
    public static function getEnv() {
        return Config::__PROD__;
    }
    public static function getStaticFolders() {
        return Config::__staticFolders;
    }

}

?>