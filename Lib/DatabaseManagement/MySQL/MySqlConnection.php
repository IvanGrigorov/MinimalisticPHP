<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once(dirname(__FILE__)."\..\DBConnection.php");
require_once(dirname(__FILE__)."\..\..\Interfaces\IDBConnection.php");


class MySqlConnection extends DBConnection implements IDBConnection {
    
    public function __construct() {
        $this->dbConnection = new mysqli(
                // host
                // username
                // password
                // dbname 
                // port
                // socket
                );
    }
    
}
