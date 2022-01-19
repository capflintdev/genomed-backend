<?php

class Product {

    // подключение к базе данных и таблице 'products'
    private $conn;
    private $table_name = "chromolab";
    private $table_category = "chrom_cat";
    private $table_tests = "chrom_tests";

    public $limit;
    public $offset;

    // свойства объекта
    public $id;
    public $article;
    public $category;
    public $category_path;
    public $name;
    public $shortinfo;
    public $longinfo;
    public $details;
    public $indications;
    public $preparation;
    public $methods;
    public $howto;
    public $results;
    public $price;

    // конструктор для соединения с базой данных
    public function __construct($db){
        $this->conn = $db;
    }

    // метод read() - получение товаров
    function read(){

        if (isset($this->limit) and isset($this->offset)){
            $query = "
            SELECT
                id, article, category, category_path, name, shortinfo, longinfo, details, indications, preparation, methods, howto, results, price
            FROM
                " . $this->table_name . " 
            LIMIT
                $this->limit
            OFFSET
                $this->offset
            ";
        } elseif (isset($this->limit)) {
            $query = "
            SELECT                
                id, article, category, category_path, name, shortinfo, longinfo, details, indications, preparation, methods, howto, results, price
            FROM
                " . $this->table_name . " 
            LIMIT
                $this->limit
            ";
        } else {
            $query = "
            SELECT   
                id, article, category, category_path, name, shortinfo, longinfo, details, indications, preparation, methods, howto, results, price
            FROM
                " . $this->table_name . " 
            ";
        }

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // выполняем запрос
        $stmt->execute();

        return $stmt;
    }

    function readAll() {
        $query = "
            SELECT
                id, category, category_path
            FROM
                " . $this->table_category . " 
            ";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // выполняем запрос
        $stmt->execute();

        return $stmt;
    }

    public function getTests($category_path) {

        $query = "
            SELECT
                price_id, article, name, shortinfo, price
            FROM
                " . $this->table_tests . " 
            WHERE 
                category_path = '{$category_path}'
            ";

        $stmt = $this->conn->prepare($query);

        // выполняем запрос
        $stmt->execute();

        return $stmt;
    }

    function readOne() {

        // запрос для чтения одной записи
        $query = "
            SELECT
                id, article, category, category_path, name, shortinfo, longinfo, details, indications, preparation, methods, howto, results, price
            FROM
                " . $this->table_name . " 
            WHERE
                id = ?
            LIMIT
                0,1";

        // подготовка запроса
        $stmt = $this->conn->prepare( $query );

        // привязываем id товара к ?
        $stmt->bindParam(1, $this->id);

        // выполняем запрос
        $stmt->execute();

        // получаем извлеченную строку
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // установим значения свойств объекта
        $this->article = $row['article'];
        $this->category = $row['category'];
        $this->category_path = $row['category_path'];
        $this->name = $row['name'];
        $this->shortinfo = $row['shortinfo'];
        $this->longinfo = $row['longinfo'];
        $this->details = $row['details'];
        $this->indications = $row['indications'];
        $this->preparation = $row['preparation'];
        $this->methods = $row['methods'];
        $this->howto = $row['howto'];
        $this->results = $row['results'];
        $this->price = $row['price'];

    }

    function readCategory() {
        if (isset($this->limit)){
            $query = "
            SELECT
                id, article, category, category_path, name, shortinfo, longinfo, details, indications, preparation, methods, howto, results, price
            FROM
                " . $this->table_name . " 
            WHERE
                category_path = ?
            LIMIT
                $this->limit
            ";
        } else {
            $query = "
            SELECT
                id, article, category, category_path, name, shortinfo, longinfo, details, indications, preparation, methods, howto, results, price
            FROM
                " . $this->table_name . " 
            WHERE
                category_path = ?
            ";
        }

        // подготовка запроса
        $stmt = $this->conn->prepare( $query );

        // привязываем category товара к ?
        $stmt->bindParam(1, $this->category_path);

        // выполняем запрос
        $stmt->execute();

        return $stmt;
    }
}