<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


include_once '../config/database.php';
include_once '../objects/category.php';


$database = new Database();
$db = $database->getConnection();

$category = new Category($db);

$stmt = $category->read();
$num = $stmt->rowCount();

// если найдены
if ($num > 0) {

    // иницциализируем массив категрий
    $categories_arr = array();

    // Ещё один массив для удобства
    $categories_arr["Категории"] = array();

    // циклом по полученым данным проходим
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        // извлекаем все данные
        extract($row);

        // расскидываем по своим местам
        $category_item = array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description)
        );

        array_push($categories_arr["Категории"], $category_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show categories data in json format
    echo json_encode($categories_arr, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} else {

    // set response code - 404 Not found
    http_response_code(404);

    echo json_encode(
        array("Сообщение" => "Нет указанных в запросе категорий"), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    );
}
?>