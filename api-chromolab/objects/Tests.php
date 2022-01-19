<?php


class Test
{
    private $conn;
    private $table_name = "chromolab";
    private $table_category = "chrom_cat";
    private $table_tests = "chrom_tests";

    public $path;
    public $article;

    public $limit;
    public $offset;

    public $price_id;
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
    public $related_tests;

    // конструктор для соединения с базой данных
    public function __construct($db){
        $this->conn = $db;
    }

    function readAll() {
        if (isset($this->category_path)){
            $query = "
            SELECT
                id, category, category_path, description
            FROM
                " . $this->table_category . " 
            WHERE 
                category_path = ?
            LIMIT 0,1
            ";
        } else {
            $query = "
            SELECT
                id, category, category_path, description
            FROM
                " . $this->table_category . " 
            ";
        }

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->category_path);

        // выполняем запрос
        $stmt->execute();

        return $stmt;
    }

    public function getTests($category_path) {

        $query = "
            SELECT
                price_id, article, category_path, name, shortinfo, longinfo, details, indications, preparation, methods, howto, results, price, related_tests
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

    public function getAllTests() {
        if (isset($this->limit) and isset($this->offset)){
            $query = "
            SELECT
                price_id, article, category_path, name, shortinfo, longinfo, details, indications, preparation, methods, howto, results,  price, related_tests
            FROM
                " . $this->table_tests . "
            LIMIT
                $this->limit
            OFFSET
                $this->offset
            ";
        } elseif (isset($this->limit)) {
            $query = "
            SELECT
                price_id, article, category_path, name, shortinfo, longinfo, details, indications, preparation, methods, howto, results,  price, related_tests
            FROM
                " . $this->table_tests . " 
            LIMIT
                $this->limit
            ";
        } else {
            $query = "
            SELECT
                price_id, article, category_path, name, shortinfo, longinfo, details, indications, preparation, methods, howto, results,  price, related_tests
            FROM
                " . $this->table_tests . " 
            ";
        }

        $stmt = $this->conn->prepare($query);

        // выполняем запрос
        $stmt->execute();

        return $stmt;
    }

    function readOne() {

        // запрос для чтения одной записи
        $query = "
            SELECT
                price_id, article, category_path, name, shortinfo, longinfo, details, indications, preparation, methods, howto, results, price, related_tests
            FROM
                " . $this->table_tests . " 
            WHERE
                article = ?
            LIMIT
                0,1";

        // подготовка запроса
        $stmt = $this->conn->prepare( $query );

        // привязываем id товара к ?
        $stmt->bindParam(1, $this->article);

        // выполняем запрос
        $stmt->execute();

        // получаем извлеченную строку
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // установим значения свойств объекта
        $this->price_id = $row['price_id'];
        $this->article = $row['article'];
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
        $this->related_tests = $row['related_tests'];
    }
}