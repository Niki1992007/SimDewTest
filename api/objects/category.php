<?php
class Category{

    // свойство для подключения к БД и имя таблицы, к которой подключаемся
    private $conn;
    private $table_name = "categories";

    // остальные свойства объекта
    public $id;
    public $name;
    public $description;
    public $created;

    // При создании объекта, австоматически поключаемся к БД
    public function __construct($db){
        $this->conn = $db;
    }

    public function readAll(){
        // выбрать все данные
        $query = "SELECT
                    id, name, description
                FROM
                    " . $this->table_name . "
                ORDER BY
                    name";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        return $stmt;
    }
}
?>