<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты
include_once '../config/database.php';
include_once '../objects/Tests.php';
// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// инициализируем объект
$product = new Test($db);
$test = New Test($db);

if (isset($_GET['path'])) {
    $product->category_path = $_GET['path'];
}

// запрашиваем товары
$stmt = $product->readAll();
$num = $stmt->rowCount();

if ($num>0) {
    // массив товаров
    $products_arr=array();
    $products_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        // извлекаем строку
        extract($row);

        $product_item=array(
            "category" => $category,
            "category_path" => $category_path,
            "description" => $description,
        );

        $product_item["tests"] = [];

        $tests = $test->getTests($category_path);
        $num2 = $tests->rowCount();

        if ($num2>0) {
            while ($rowTest = $tests->fetch(PDO::FETCH_ASSOC)) {

                extract($rowTest);

                $testsArray = array(
                    "price_id" => $price_id,
                    "article" => $article,
                    "name" => $name,
                    "shortinfo" => $shortinfo,
                    "longinfo" => $longinfo,
                    "details" => $details,
                    "indications" => $indications,
                    "preparation" => $preparation,
                    "methods" => $methods,
                    "howto" => $howto,
                    "results" => $results,
                    "price" => $price,
                    "related_tests" => $related_tests
                );

                array_push($product_item["tests"], $testsArray);
            }
        }

        array_push($products_arr["records"], $product_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);

    // выводим данные о товаре в формате JSON
    echo json_encode($products_arr);
} else {

    // установим код ответа - 404 Не найдено
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены
    echo json_encode(array("message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}


