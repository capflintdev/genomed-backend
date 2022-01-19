<?php


class Category
{
    private $conn;
    private $table_category = "chrom_cat";

    public $category;
    public $category_path;
    public $description;


    // конструктор для соединения с базой данных
    public function __construct($db){
        $this->conn = $db;
    }

    function readOneCategory() {

        // запрос для чтения одной категории
        $query = "
            SELECT
                category, category_path, description
            FROM
                " . $this->table_category . " 
            WHERE
                category_path = ?
            LIMIT
                0,1";

        // подготовка запроса
        $stmt = $this->conn->prepare( $query );

        // привязываем id товара к ?
        $stmt->bindParam(1, $this->category_path);

        // выполняем запрос
        $stmt->execute();

        // получаем извлеченную строку
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // установим значения свойств объекта
        $this->category = $row['category'];
        $this->category_path = $row['category_path'];
        $this->description = $row['description'];
    }

}