<?php

ini_set('display_errors', 1); // вывести ошибки на экран
error_reporting(E_ALL); // все

// Домашняя страница
$home_url = $_SERVER['HTTP_HOST'] . "/api/";

// Укажем страницу в параметре GET, по-умолчанию одна
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// количество записей разрешённых для вывода на странице
$records_per_page = 5;

// вычтем из общего кол-ва записей, произведение разрешённых для вывода записей и текущей страницы, вернувшейся из GET, минус кол-во разр-х для вывода записей
$from_record_num = ($records_per_page * $page) - $records_per_page;
?>