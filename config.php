<?php 

final  class Config {

    const __DEV__ = "DEV";
    const __PROD__ = "PROD";   
    //private $__env = __DEV__;
    const __staticFolders = [
        "Assets/Images",
        "Assets/Scripts",
        "Assets/Styles"
    ];
    const __DATABASENAME = "YOUR DATABASE NAME";
    
    public static function getEnv() {
        return Config::__PROD__;
    }
    public static function getStaticFolders() {
        return Config::__staticFolders;
    }
    
    public static function getDatabaseName() {
        return Config::__DATABASENAME;
    }
}

?>