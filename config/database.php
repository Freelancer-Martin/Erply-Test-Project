<?php
class Database{

    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "api_db";
    private $username = "root";
    private $password = "";
    public $conn;


/*
    public function __construct($db){
        $this->createDatabaseTable();
    }
*/

    // get the database connection
    public function createDatabaseTable(){

        $this->conn = null;

        try{

            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);

            // sql to create table
            $sql = "CREATE TABLE IF NOT EXISTS product (
              id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              name VARCHAR(100) NOT NULL,
              price INT(20) NOT NULL

            )";

            // use exec() because no results are returned
            $this->conn->exec($sql);
            echo "Table MyGuests created successfully";
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }

/*
    // get the database connection
    public function insertDatabaseTable(){

        $this->conn = null;

        try{

            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);

            // sql to create table
            $sql = "INSERT INTO IF NOT EXISTS product (name, price)
            VALUES ('John', '15' )";

            if ($this->conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>";
            }

            // use exec() because no results are returned
            $this->conn->exec($sql);
            echo "Table MyGuests created successfully";
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
*/


    // get the database connection
    public function getConnection(){

        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            echo "Houston we have connection";
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
