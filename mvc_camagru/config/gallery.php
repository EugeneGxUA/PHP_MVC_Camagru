<?php
/**
 * Created by PhpStorm.
 * User: egaragul
 * Date: 5/11/17
 * Time: 17:38
 */

$dir = ROOT."/templates/gallery/big_images/";
$small_dir = "/mvc_camagru/templates/gallery/big_images/";

$images = get_images($dir);


/*-------------------------------------*/
/* --       pagination      -- */

//фото на страницу
$pre_page = 3;

//считаем файлы в папке
$count_img = count($images);

//результат деления - сколько нужно страниц
$count_pages = ceil($count_img / $pre_page);

if (!$count_pages) $count_pages = 1;

//получаем номер скраницы

if (isset($_GET['page']))
{
    $page = (int)$_GET['page'];
    if ($page < 1) $page = 1;
}
else
{
    $page = 1;
}
if ($page > $count_pages)$page = $count_pages;

//первая картинка на страницу
/*
 * pre_page - определяем сколько фото будет на странице
 * page - на какой странице находимся на данный момент
 * стартовая позиция = на какой странице сейчас - 1 * на сколичество картинок -- 0 = (1 - 1) * 6 = 0
 */
$start_pos = ($page - 1) * $pre_page;

//последняя картинка на странице
$end_pos = $start_pos + $pre_page;

//если конечная позиция по счетчику больше количества фото то присваиваем значение $count_img
if ($end_pos > $count_img) $end_pos = $count_img;

//получаем пагинацию

$pagination = pagination($page, $count_pages);


/* ----------------------------------------- */



function get_images($dir)
{
   $files = scandir($dir);

   unset($files[0], $files[1]);
   $pattern = "#\.(jpe?g|png|gif)$#i";
   foreach ($files as $key => $file)
   {
       if (!preg_match($pattern, $file))
       {
           unset($files[$key]);
       }
   }
   $files =array_merge($files);
   return $files;
}

/**
 * Постраничная навигация
 **/
function pagination($page, $count_pages, $modrew = false)
{
    // << < 3 4 5 6 7 > >>
    $back = null; // ссылка НАЗАД
    $forward = null; // ссылка ВПЕРЕД
    $startpage = null; // ссылка В НАЧАЛО
    $endpage = null; // ссылка В КОНЕЦ
    $page2left = null; // вторая страница слева
    $page1left = null; // первая страница слева
    $page2right = null; // вторая страница справа
    $page1right = null; // первая страница справа

    $uri = "?";
    if(!$modrew)
    {
        // если есть параметры в запрос
        if( $_SERVER['QUERY_STRING'] )
        {
            foreach ($_GET as $key => $value)
            {
                if( $key != 'page' ) $uri .= "{$key}=$value&amp;";
            }
        }
    }
    else
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode("?", $url);
        if(isset($url[1]) && $url[1] != '')
        {
            $params = explode("&", $url[1]);
            foreach($params as $param)
            {
                if(!preg_match("#page=#", $param))
                {
                    $uri .= "{$param}&amp;";
                }
            }
        }
    }

    if( $page > 1 )
    {
        $back = "<a class='nav-link' href='{$uri}page=" .($page-1). "'>&lt;</a>";
    }
    if( $page < $count_pages )
    {
        $forward = "<a class='nav-link' href='{$uri}page=" .($page+1). "'>&gt;</a>";
    }
    if( $page > 3 )
    {
        $startpage = "<a class='nav-link' href='{$uri}page=1'>&laquo;</a>";
    }
    if( $page < ($count_pages - 2) )
    {
        $endpage = "<a class='nav-link' href='{$uri}page={$count_pages}'>&raquo;</a>";
    }
    if( $page - 2 > 0 )
    {
        $page2left = "<a class='nav-link' href='{$uri}page=" .($page-2). "'>" .($page-2). "</a>";
    }
    if( $page - 1 > 0 )
    {
        $page1left = "<a class='nav-link' href='{$uri}page=" .($page-1). "'>" .($page-1). "</a>";
    }
    if( $page + 1 <= $count_pages )
    {
    $page1right = "<a class='nav-link' href='{$uri}page=" .($page+1). "'>" .($page+1). "</a>";
    }
    if( $page + 2 <= $count_pages )
    {
    $page2right = "<a class='nav-link' href='{$uri}page=" .($page+2). "'>" .($page+2). "</a>";
    }
    return $startpage.$back.$page2left.$page1left.'<a class="nav-active">'.$page.'</a>'.$page1right.$page2right.$forward.$endpage;
}