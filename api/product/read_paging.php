<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


include_once '../shared/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/product.php';


$utilities = new Utilities();

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);


// метод вернёт массив записей, ограниченных $records_per_page в core.php
$stmt = $product->readPaging($from_record_num, $records_per_page);

$num = $stmt->rowCount(); //Возвращает количество строк, затронутых последним SQL-запросом

// Еслир записи вообще есть
if ($num > 0) {

    $products_arr = array();

    $products_arr["Продукты"] = array();

    $products_arr["Пагинация"] = array();


    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {


        extract($row);

        $product_item = array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description),
            "price" => $price,
            "category_id" => $category_id,
            "category_name" => $category_name
        );

        array_push($products_arr["Продукты"], $product_item); // сольём массивы
    }


    // пагинация
    $total_rows = $product->count();
    $page_url = "{$home_url}product/read_paging.php?";
    $paging = $utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $products_arr["Пагинация"] = $paging;

    // response code - 200 OK
    http_response_code(200);

    // json format
    echo json_encode($products_arr, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
} else {

    // response code - 404 Not found
    http_response_code(404);

    // сообщение что продукты не найдены
    echo json_encode(
        array("message" => "Больше продуктов нет"), JSON_UNESCAPED_UNICODE
    );
}
?>
