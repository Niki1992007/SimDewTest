
Администрирование БД тут: 

https://vip11.hostiman.ru/phpmyadmin/index.php

1) БД: api_db

2) Пользователь: simdew

3) Пароль: simdew_test

4) Удалённый доступ: ДА

5) Адрес сервера БД: localhost, 51.91.19.195

===================================================

FTP пользователь:

Адрес (хост, IP): vip11.hostiman.ru

Порт: 21

Имя: simdew

Пароль: simdew_test

Директория: /www/onlly-freedom.ru

=====================================================

Описаны 2 класса; 

  1) /api/objects/product.php - методы и свойства для работы с продуктами:

    - read(); - вывести информацию о всех продуктах, пройдите по https://onlly-freedom.ru/api/product/read.php
    
    - readOne(); - получить информацию ою одном продукте по id, пример https://onlly-freedom.ru/api/product/read_one.php?id=3
    
    - search($keywords); - поиск по продуктам, например так https://onlly-freedom.ru/api/product/search.php?s=fashion мы можем получить все продукты для категории Fashion
    
    - readPaging(); - выводить проукты постранично (всего пять штук для страницы). Пример: https://onlly-freedom.ru/api/product/read_paging.php?page=1 для первой страницы
    
    - count(); - помогает расчитать кол-во записей для страницы
    
   2) /api/objects/category.php - методы и свойства для работы с категориями
 
    - read(); - вывести все категории. Пример: https://onlly-freedom.ru/api/category/category-read.php
    
    
   3) /api/config/database.php - конфигурационный файл
   
   4) /api/shared/ - вспомогательные функции (вывод ошибок, расчёт пагинации)