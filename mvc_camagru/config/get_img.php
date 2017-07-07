<?php

require_once  '../components/Session.php';

if (array_key_exists('photo', $_POST))
{
    $session = Session::getInstance();



    $dsn = "mysql:host=localhost;dbname=camagru";
    try
    {
        $pdo = new PDO($dsn, "root", "egaragul");
    }
    catch (PDOException $e)
    {
        echo "Connection error :". $e->getMessage();
        exit();
    }

    $img = $_POST['photo'];
    $ph = $_POST['src1'];
    $login = $session->logged_user;
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);



    $login = $session->logged_user;
    /*$login = $session->logged_user;*/

    $query_login = $pdo->prepare("INSERT INTO `images` (user_login) VALUES ('$login')");
    $query_login->execute();

    $query_id = $pdo->prepare("SELECT MAX(id) FROM `images`");
    $query_id->execute();
    $result = $query_id->fetch(PDO::FETCH_ASSOC);
    $id = $result['MAX(id)'];


    $query_update = $pdo->prepare("UPDATE `images` SET `image` = '$id.png' WHERE id = '$id'");
    $query_update->execute();

    file_put_contents("../images/gallery/$id.png", $data);
    $frame = imagecreatefrompng("..".$ph);

    $image = imagecreatefrompng("../images/gallery/$id.png");

    ImageCopy($image, $frame, 140, 10, 0, 0, 150, 150);
    imagepng($image, "../images/gallery/$id.png");
}