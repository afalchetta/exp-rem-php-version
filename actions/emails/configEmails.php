<?php

    /* DATABASE CONFIGURATION */
    define('DB_SERVER_EMAIL', 'localhost');
    define('DB_USERNAME_EMAIL', '');
    define('DB_PASSWORD_EMAIL', '');
    define('DB_DATABASE_EMAIL', '');
    define("BASE_URL", "");


    function getDB_email()
    {
    $dbhost=DB_SERVER_EMAIL;
    $dbuser=DB_USERNAME_EMAIL;
    $dbpass=DB_PASSWORD_EMAIL;
    $dbname=DB_DATABASE_EMAIL;
    try {
    $dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbConnection->exec("set names utf8");
    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbConnection;
    }
    catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    }

    }?>
