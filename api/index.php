<?php

$file = include_once 'objects/product.php';
$is_valid_utf8 = mb_check_encoding($file, 'utf-8');
var_dump($is_valid_utf8);