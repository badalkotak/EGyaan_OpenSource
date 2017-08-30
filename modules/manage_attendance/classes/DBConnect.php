<?php
require_once("Constants.php");
class DBConnect{
    private $serverName = Constants::SERVER_NAME;
    private $username = Constants::DB_USERNAME;
    private $password = Constants::DB_PASSWORD;
    private $dbName = Constants::DB_NAME;
    var $conn;

    function getInstance(){
        if($this->conn != null){
            return $this->conn;
        }

        $this->conn = new mysqli($this->serverName, $this->username, $this->password, $this->dbName);
        if ($this->conn->connect_error) {
            return null;
        }else{
            return $this->conn;
        }
    }
}