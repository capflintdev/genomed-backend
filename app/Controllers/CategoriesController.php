<?php

namespace App\Controllers;

use PDO;

class CategoriesController
{
    private string $category_table = 'chrom_cat';
    private PDO $connection;
    protected array $array;
    protected string $category_path;

    public function __construct()
    {
        $this->connection = (new \App\DB((new \App\Config())->extract()))->getPdo();
    }

    public function read(string $category_path): array
    {
        $query = "
            SELECT
                category, category_path, description
            FROM
                " . $this->category_table . " 
            WHERE
                category_path = ?
            LIMIT
                0,1";

        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(1, $category_path);

        $stmt->execute();

        $array = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->category = $array['category'];
        $this->category_path = $array['category_path'];
        $this->description = $array['description'];

        return $array;
    }

    public function index()
    {
        try {
            $this->category_path = $_GET['path'] ?? die();
            http_response_code(200);
            echo json_encode($this->read($this->category_path));
            unset($this->category_path);
        } catch (\PDOException $e) {
            http_response_code(404);
            echo json_encode(array("message" => "Записи не существует."), JSON_UNESCAPED_UNICODE);
        }
    }
}