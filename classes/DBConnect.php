<?php
class DBConnect{
    var $serverName;
    var $username;
    var $password;
    var $dbName;

    function __construct( $serverName, $username, $password, $dbName ) {
        $this->serverName = $serverName;
        $this->username = $username;
        $this->password = $password;
        $this->dbName = $dbName;
    }

    function getInstance(){
        $conn = new mysqli($this->serverName, $this->username, $this->password, $this->dbName);
        if ($conn->connect_error) {
            return null;
        }else{
            return $conn;
        }
    }
}