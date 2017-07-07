<?php

class Model_main
{
    public static function save_comment($comment, $photo_src)
    {
        $pdo = Db::getConnection();
        $session = Session::getInstance();

        $login = $session->logged_user;

        $query = $pdo->prepare("INSERT INTO `photo_comments` (`user_login`, `photo_id`, `comment`) VALUES ('$login', '$photo_src', '$comment')");
        $query->execute();


    }

    public static function do_load($photo, $frame)
    {
        $img = str_replace('data:image/png;base64,', '', $photo);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);

        $session = Session::getInstance();
        $login = $session->logged_user;

        //connect to DB
        $pdo = Db::getConnection();

        $query_login = $pdo->prepare("INSERT INTO `images` (user_login) VALUES ('$login')");
        $query_login->execute();

        $query_id = $pdo->prepare("SELECT MAX(id) FROM `images`");
        $query_id->execute();
        $result = $query_id->fetch(PDO::FETCH_ASSOC);
        $id = $result['MAX(id)'];

        $query = $pdo->prepare("UPDATE `images` SET `image` = '$id.png' WHERE id = '$id'");
        $query->execute();

        file_put_contents("./images/gallery/$id.png", $data);

        $frame = imagecreatefrompng(".".$frame);

        $image = imagecreatefrompng("./images/gallery/$id.png");

        ImageCopy($image, $frame, 140, 10, 0, 0, 150, 150);
        imagepng($image, "./images/gallery/$id.png");

    }

    public static function like($src)
    {


            var_dump($src);
            $session = Session::getInstance();
            $pdo = Db::getConnection();

            $login = $session->logged_user;
            $counter = 0;

            $query_login = $pdo->prepare("SELECT `photo_id` FROM `like` WHERE `photo_id` = '$src' AND `user_login` = '$login'");
            $query_login->execute();

            $result = $query_login->fetch(PDO::FETCH_ASSOC);
            if ($result == NULL)
            {
                $query = $pdo->prepare("INSERT INTO `like` (user_login, likes, photo_id) VALUES ('$login', '$counter', '$src')");
                $query->execute();
            }
            else
            {
                $query = $pdo->prepare("DELETE FROM `like` WHERE `photo_id` = '$src' AND `user_login` = '$login'");
                $query->execute();
            }
            $query = $pdo->prepare("SELECT COUNT(`photo_id`) AS `col` FROM `like` WHERE `photo_id` = '$src'");
            $query->execute();

            $result = $query->fetch(PDO::FETCH_ASSOC);
            var_dump($result);
            (int)$counter = $result['col'];
            if ($counter != NULL)
            {
                $query = $pdo->prepare("UPDATE `images` SET likes = '$counter' WHERE `image` = '$src'");
                $query->execute();

                return (TRUE);
            }

            else
                return (TRUE);
            //return TRUE;


    }

    public static function take_like($src)
    {
        $pdo = Db::getConnection();

        $query = $pdo->prepare("SELECT  `likes` FROM `images` WHERE `image` = '$src'");
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $like = $result['likes'];
        $query = $pdo->prepare("SELECT  `user_login` FROM `images` WHERE `image` = '$src'");
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $author = $result['user_login'];
        if ($like != 0)
        {
            echo $like;
        }
        echo "<br /> author photo : ".$author."<br /><br />";


        $query = $pdo->prepare("SELECT * FROM `photo_comments` WHERE `photo_id` = '$src' ORDER BY `creation_date` DESC");
        $query->execute();
        $result = array();
        $result_query = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result_query as $elem)
        {
            echo "Дата :".$elem['creation_date']." <br />".$elem['user_login'].": ".$elem['comment']." <br /><br />";

        }
    }

}

