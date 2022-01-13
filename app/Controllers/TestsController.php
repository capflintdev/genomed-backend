<?php

namespace App\Controllers;

use PDO;

class TestsController
{
    private string $category_table = 'chrom_cat';
    private string $tests_table = 'chrom_tests';
    private PDO $connection;
    protected array $array;
    protected string|null $category_path;
    protected int $categoriesRowsNum = 0;

    public function __construct()
    {
        $this->connection = (new \App\DB((new \App\Config())->extract()))->getPdo();
    }

    public function readCategories(): array
    {
        if (isset($this->category_path)){
            $query = "
            SELECT
                id, category, category_path, description
            FROM
                " . $this->category_table . " 
            WHERE 
                category_path = ?
            LIMIT 0,1
            ";
        } else {
            $query = "
            SELECT
                id, category, category_path, description
            FROM
                " . $this->category_table . " 
            ";
        }

        $stmt = $this->connection->prepare($query);

        if(isset($this->category_path)){
            $stmt->bindParam(1, $this->category_path);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readTests(string $category_path): array
    {
        $query = "
            SELECT
                price_id, article, category_path, name, shortinfo, longinfo, details, indications, preparation, methods, howto, results, price, related_tests
            FROM
                " . $this->tests_table . " 
            WHERE 
                category_path = '{$category_path}'
            ";

        $stmt = $this->connection->prepare($query);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function index()
    {
        $this->category_path = $_GET['path'] ?? null;

        if ($this->rowCount() > 0) {
//            unset($this->categoriesRowsNum);
            foreach ($this->readCategories() as $category) {
                foreach ($this->readTests($category['category_path']) as $test) {
                    $category['tests'][] = [
                        "price_id" => $test['price_id'],
                        "article" => $test['article'],
                        "name" => $test['name'],
                        "shortinfo" => $test['shortinfo'],
                        "longinfo" => $test['longinfo'],
                        "details" => $test['details'],
                        "indications" => $test['indications'],
                        "preparation" => $test['preparation'],
                        "methods" => $test['methods'],
                        "howto" => $test['howto'],
                        "results" => $test['results'],
                        "price" => $test['price'],
                        "related_tests" => $test['related_tests']
                    ];
                }
                $this->array["records"][] = $category;
            }
            http_response_code(200);
            echo json_encode($this->array);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Тесты не найдены."), JSON_UNESCAPED_UNICODE);
        }
    }

    public function tests()
    {
//        $this->category_path = $_GET['path'] ?? null;
//        http_response_code(200);
//        echo json_encode($this->readTests());
    }

    private function rowCount(): int
    {
        foreach ($this->readCategories() as $category) {
            $this->categoriesRowsNum++;
        }
        return $this->categoriesRowsNum;
    }
}