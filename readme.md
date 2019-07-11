Описаны 2 класса; 

  1) /api/objects/product.php - методы и свойства для работы с продуктами:

    - read(); - вывести информацию о всех продуктах, пройдите по /api/product/read.php
    
    - readOne(); - получить информацию ою одном продукте по id, пример /api/product/read_one.php?id=3
    
    - search($keywords); - поиск по продуктам, например так /api/product/search.php?s=fashion мы можем получить все продукты для категории Fashion
    
    - readPaging(); - выводить проукты постранично (всего пять штук для страницы). Пример: /api/product/read_paging.php?page=1 для первой страницы
    
    - count(); - помогает расчитать кол-во записей для страницы
    
   2) /api/objects/category.php - методы и свойства для работы с категориями
 
    - read(); - вывести все категории. Пример: /api/category/category-read.php
    
    
   3) /api/config/database.php - конфигурационный файл
   
   4) /api/shared/ - вспомогательные функции (вывод ошибок, расчёт пагинации)
