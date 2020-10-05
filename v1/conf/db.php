<?php

class Db {

    private $host = "obrianddata.mysql.db";
    private $db_name = "obrianddata";
    private $username = "obrianddata";
    private $password = "Belierdata00";
    public $connection;

    // get the database connection
    public function getConnection() {
        $this->connection = null;

        try {
            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->connection->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Database connection error: " . $exception->getMessage();
        }

        return $this->connection;
    }

}

?>
