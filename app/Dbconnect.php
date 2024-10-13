<?php 

class Dbconnect{
    private $hostname = 'localhost';
    private $username = 'root';
    private $password = '';
    private $databse = 'project1';

    /* 
        Main connection funciton for database

        @return Object(mysqli)
    */
    protected function connect() {

        $conn = new mysqli($this->hostname, $this->username, $this->password, $this->databse);
        
        if($conn->connect_error){
            throw new Exception('Failed connecting to database' . $conn->error);
            return 0;
        }
        return $conn;
    }
}