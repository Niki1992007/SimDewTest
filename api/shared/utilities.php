<?php

// Поможет посичтать страницы на текущем урл
class Utilities{

    public function getPaging($page, $total_rows, $records_per_page, $page_url){

        // массив страниц
        $paging_arr=array();

        // кнопка для первой страницы
        $paging_arr["Первая страница"] = $page>1 ? "{$page_url}page=1" : $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        // подсчитать все товары в базе данных для подсчета общего количества страниц
        $total_pages = ceil($total_rows / $records_per_page);

        // диапазон ссылок, которые мы покажем
        $range = 2;

        // диапазон ссылок, которые будут отбражены для текущей страницы
        $initial_num = $page - $range;
        $condition_limit_num = ($page + $range)  + 1;

        $paging_arr['Страниц всего']=array();
        $page_count=0;

        for($x=$initial_num; $x<$condition_limit_num; $x++){
            // счётчик больше нуля или <= общего количества страниц
            if(($x > 0) && ($x <= $total_pages)){

                // страницы
                $paging_arr['Страниц всего'][$page_count]["страница"]=$x;

                // страницы в урл
                $paging_arr['Страниц всего'][$page_count]["url"]="{$page_url}page={$x}";

                // Условие по которому будет определяться текщая старница
                $paging_arr['Страниц всего'][$page_count]["текущая"] = $x==$page ? "да" : "нет";

                $page_count++;
            }
        }

        // кнопка для последней страницы
        $paging_arr["Последняя старница"] = $page<$total_pages ? "{$page_url}page={$total_pages}" : "";

        // json format
        return $paging_arr;
    }

}
?>