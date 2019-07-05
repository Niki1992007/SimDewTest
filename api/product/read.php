<?php
// заголовки запроса
header("Access-Control-Allow-Origin: *"); // файл может быть прочитан кем угодно
header("Content-Type: application/json; charset=UTF-8"); // данные в формате JSON

// включить базу данных и объектные файлы
include_once '../config/database.php';
include_once '../objects/product.php';

// создание экземпляр класса подключения к БД
$database = new Database();
$db = $database->getConnection();

// инициализация объекта продукта
$product = new Product($db);

// запросы к объекту продукт
$stmt = $product->read(); // метод, прочитать из БД
$num = $stmt->rowCount(); // проверить, найдены ли записи

// если записи есть
if($num>0){

    // вернуть масиив записей продуктов
    $products_arr=array();
    $products_arr["Продукты"]=array(); // добавляем для удобства

    // вернуть содержимое таблицы
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        // извлечь всю строку полностью
        // если нужно, например, только имя - использовать $row['name']
        extract($row);

        $product_item=array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description),
            "price" => $price,
            "category_id" => $category_id,
            "category_name" => $category_name
        );

        array_push($products_arr["Продукты"], $product_item); // сливаем два массива
    }

    // если всё хорошо то код ответа - 200 OK
    http_response_code(200);

    // преобразовать в JSON
    echo json_encode($products_arr, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);

    // если продукты не найдены
    } else {

    // выстовляем статус код - 404 Not found
    http_response_code(404);

    // также сообщаем об этом в JSON
    echo json_encode(
        array("Сообщение" => "Продукты не найдены!"), JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT
);
}