<?php
    
final class FilterApplier {
    
    // These checks (filters) should be done only on global data
    // Example $_SESSION[]
    
    public static function checkIfUserIsLogged() {
        
    } 
    
    public static function checkIfUserIsAdmin() {
        
    }
    
    public static function checkForRightDomain() {
        if ($_SERVER["SERVER_NAME"] === "localhost" ) {
            return true ;
        }
        return false;
    }


}