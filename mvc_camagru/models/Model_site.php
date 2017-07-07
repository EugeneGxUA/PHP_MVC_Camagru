<?php


class Model_site
{
    public $dir;
    public $small_path;
    public $pre_page;
    public $count_img;
    public $images;
    public $count_pages;
    public $page;
    public $start_pos;
    public $end_pos;
    public $pagination;
    public $pdo;
    public $img;
    public $like;

    function __construct(array $kwargs)
    {
        $this->pdo = Db::getConnection();
        $this->dir = ROOT."/images/gallery/";
        $this->small_path = "/mvc_camagru/images/gallery/";
        $this->pre_page = 9;

        $this->img = $this->getImage($this->pdo);

        //$this->images = $this->get_images($this->dir);
        $this->count_img = count($this->img);
        $this->count_pages = ceil($this->count_img / $this->pre_page);
        @$this->page = $this->try_get($kwargs['page'], $this->count_pages);

        $this->start_pos = ($this->page - 1) * $this->pre_page;
        $this->end_pos = ($this->start_pos + $this->pre_page);
        $this->pagination = $this->pagination($this->page, $this->count_pages);

        if ($this->start_pos < 0) $this->start_pos = 0;

        if ($this->end_pos > $this->count_img) $this->end_pos = $this->count_img;

        if (!$this->count_pages) $this->count_pages = 1;
    }

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
        $files = array_merge($files);
        return $files;
    }

    function try_get($get, $count_pages)
    {
        if (isset($get))
        {
            $page = (int)$get;
            if ($page < 1) $page = 1;
        }

        else
        {
            $page = 1;
        }

        if ($page > $count_pages)$page = $count_pages;

        return ($page);

    }

    function getImage($pdo)
    {
        $query = $pdo->prepare("SELECT * FROM `images`");
        $query->execute();
        $img = array();
        $like = array();

        while ($row = $query->fetch(PDO::FETCH_ASSOC))
        {
           /* echo "<div id='img_div'>";
            var_dump($row);
            echo "<img  src='/mvc_camagru/images/gallery/$aa'>";
            echo "<p>".$row['title']."</p>";
            echo "</div>";*/
            $img[] = $row['image'];
        }


        return $img;
    }

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
            // если есть параметры в запросе
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

}