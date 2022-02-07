<?php

class Database {

    // укажите свои учетные данные базы данных
    private $host = "db-chromolab-do-user-10360923-0.b.db.ondigitalocean.com:25060";
    private $db_name = "genomed";
    private $username = "doadmin";
    private $password = "swWCNwdNmCxd8BNy";
    public $conn;


    // получаем соединение с БД
    public function getConnection(){

        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}