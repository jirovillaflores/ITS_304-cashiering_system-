<?php

class Dbh
{
    public $host = "localhost";
    public $user = "root";
    public $pwd = "";
    public $dbName = "r&r_dbs";
    protected $conn;

    public function connect()
    {
        $this->conn = new mysqli(
            $this->host,
            $this->user,
            $this->pwd,
            $this->dbName
        );

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        return $this->conn;
    }
}
