<?php

class Database {

    // укажите свои учетные данные базы данных
    private $host = "77.222.56.111";
    private $db_name = "testchebur_chrom";
    private $username = "testchebur_chrom";
    private $password = "!Ery4k5*JVQR_u";
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