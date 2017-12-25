<?php 

final  class Config {

    private $__env = "DEV";
    private $__staticFolders = [];
    public static function getEnv() {
        return Config::$__env;
    }
    public static function getStaticFolders() {
        return Config::$__staticFolders;
    }

}

?>