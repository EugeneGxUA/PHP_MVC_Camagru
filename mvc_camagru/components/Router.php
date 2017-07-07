<?php

/**
 * Created by PhpStorm.
 * User: egaragul
 * Date: 5/5/17
 * Time: 20:02
 */

class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT.'/config/routes.php';
        $this->routes = include($routesPath);
    }


    // return request string
    // @return string
    private function getURI()
    {
        if ( !empty($_SERVER['REQUEST_URI']) )
        {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }


    public function run()
    {
        // ---- принимает управление от фронт контроллера(индекс.пхп)

        //Получить строку запроса
        $uri = $this->getURI();

        //Проверить наличие такого запроса в routes.php
        foreach ($this->routes as $uriPattern => $path)
        {

           // echo $uriPattern.' --> '.$path.'<br/>';

           // echo $uri;
            //Если есть совпадение, то определить какой контроллер и action обрабатывают запрос
            if (preg_match("~$uriPattern~", $uri))
            {
                /* echo '<br/>Где ищем (запрос который набрал пользователь):  '.$uri;
                        echo '<br/>Что ищем (совпадение из правил):  '.$uriPattern;
                        echo '<br/>Кто обрабатывает :  '.$path;*/

                //ищем в URI совпадения по патерну, заменяем в path(regExp) на найденые совпадения и помещаем в internalRoute
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                /*echo '<br/><br>Нужно сформировать : '.$internalRoute;*/

                //Определить какой контроллер и action обрабатывает запрос

                $segments = explode('/', $internalRoute);

                //получим результат - 1й = контроллер(класс) и 2й = action(метод)
                $controllerName = array_shift($segments);

                $model_name = 'Model_'.$controllerName;

                $controllerName = $controllerName.'Controller';
                $controllerName = ucfirst($controllerName);

                $actionName = 'action'.ucfirst(array_shift($segments));

                // подцепляем файл с классом модели (файла модели может и не быть)
                $model_file = strtolower($model_name).'.php';
                $model_file = ucfirst($model_file);
                $model_path = ROOT.'/models/'.$model_file;
                if (file_exists($model_path))
                {
                    include_once ($model_path);
                }

               /* echo "<br>controller name : ".$controllerName;
                echo "<br>actionNmae : ".$actionName;*/
                $parameters = $segments;
/*                 echo "<br>";
                 echo "<pre>";
                 print_r($parameters);
                echo "</pre>";*/

                //Подключить файл класса контроллер
                $controllerFile = ROOT.'/controllers/'.$controllerName.'.php';

                if ( file_exists($controllerFile) )
                {
                    include_once ($controllerFile);
                }


                //Создать объект, вызвать метод (action)
                $controllerObject = new $controllerName;
                //                              отправляем оставшиеся параметры в функцию для определения вывода
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                if ($result != NULL)
                {
                    break;
                }
            }
        }


    }
}