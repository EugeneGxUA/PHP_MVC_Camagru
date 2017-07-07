<?php

class Db
{
    public static function createDB()
    {
        try
        {
            $pdo = new PDO('mysql:host=localhost;dbname=', 'root', "egaragul");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            echo "Connection error :". $e->getMessage();
            exit();
        }

        $query = 'CREATE DATABASE IF NOT EXISTS `camagru`';

        try
        {
            $pdo->query($query);
        }
        catch (PDOException $e)
        {
            echo "Error: Can't CREATE DataBase - ".$e;
            exit();
        }
    }

    public static function createTable()
    {
        try
        {
            $pdo = new PDO('mysql:host=localhost;dbname=camagru', 'root', "egaragul");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            echo "Connection error :". $e->getMessage();
            exit();
        }
        $query = "CREATE TABLE IF NOT EXISTS `signup` (user_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL, login VARCHAR(60) NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(500), status INT DEFAULT 0)";
        try
        {
            $pdo->query($query);
        }
        catch (PDOException $e)
        {
            echo "Error: Can't CREATE TABLE - ".$e;
            exit();
        }

        $query = "CREATE TABLE IF NOT EXISTS `images` (id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL, user_login VARCHAR(60) NOT NULL, image VARCHAR(500) NOT NULL, `likes` INT, comments VARCHAR(1000)  )";
        try
        {
            $pdo->query($query);
        }
        catch (PDOException $e)
        {
            echo "Error: Can't CREATE TABLE - ".$e;
            exit();
        }

        $query = "CREATE TABLE IF NOT EXISTS `like` (id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL, user_login VARCHAR(60) NOT NULL, `likes` INT NOT NULL, `photo_id` VARCHAR(100) NOT NULL)";
        try
        {
            $pdo->query($query);
        }
        catch (PDOException $e)
        {
            echo "Error: Can't CREATE TABLE - ".$e;
            exit();
        }
        $query = "CREATE TABLE IF NOT EXISTS `photo_comments` (user_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL, `user_login` VARCHAR(60) NOT NULL, `photo_id` VARCHAR(100) NOT NULL, `comment` VARCHAR(500), `creation_date` DATETIME DEFAULT CURRENT_TIMESTAMP)";
        try
        {
            $pdo->query($query);
        }
        catch (PDOException $e)
        {
            echo "Error: Can't CREATE TABLE - ".$e;
            exit();
        }


    }

    public static function getConnection()
    {
        $paramsPath = ROOT.'/config/db_params.php';
        $params = include($paramsPath);

        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        try
        {
            $db = new PDO($dsn, $params['user'], $params['password']);
        }
        catch (PDOException $e)
        {
            echo "Connection error :". $e->getMessage();
            exit();
        }
        return $db;
    }
}