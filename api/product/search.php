<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// файл core.php будет содержать информацию о базовой странице, настрйоки вывода ошибок и переменные пагинации
/*include_once '../config/core.php';*/

// Всё тоже что и в других файлах
include_once '../config/database.php';
include_once '../objects/product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

// указать ключевые слова по которым будет осуществляться поиск
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";

// метод поиска
$stmt = $product->search($keywords);
$num = $stmt->rowCount(); //Возвращает количество строк, затронутых последним SQL-запросом

// если записей больше 0
if($num>0){

    // массив продуктов
    $products_arr=array();
    $products_arr["records"]=array(); // c ключом records


    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        // получить занчения, для конкретного вывода  extract($row['name']);
        extract($row);

        // передать значения
        $product_item=array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description), // Преобразует HTML-сущности в соответствующие им символы
            "price" => $price,
            "category_id" => $category_id,
            "category_name" => $category_name
        );

        array_push($products_arr["records"], $product_item); // слить массивы
    }

    // set response code - 200 OK
    http_response_code(200);

    // данные о продукте
    echo json_encode($products_arr, JSON_PRETTY_PRINT);

} else {

    // set response code - 404 Not found
    http_response_code(404);


    echo json_encode(
        array("message" => "Запрашиваемые продукты не найдены"), JSON_UNESCAPED_UNICODE
    );
}
?>