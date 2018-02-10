<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once(dirname(__FILE__)."\..\Interfaces\IDBConnection.php");

abstract class DBConnection implements IDBConnection{
    
    protected $dbConnection;
    
    public function getDBConnection() {
        return $this->dbConnection;
    }
    
    public function setDBConnection($dbConnection) {
        $this->dbConnection = $dbConnection;      
    }
    
    public function closeDBConnection() {
        $this->dbConnection->close();
    }
}
