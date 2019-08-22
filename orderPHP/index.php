<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/include.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/html/index.html';

session_start();

var_dump($_SESSION);
var_dump($_COOKIE);
var_dump('1');

if (isset($_POST["email"]) && isset($_POST["pass"])) {
    $authResponse = Order\Database::checkAuthData($_POST["email"], $_POST["pass"]);
    var_dump($authResponse);
    if ($authResponse["success"]) {
        $_SESSION['userId'] = $authResponse["data"];
        $_COOKIE['userId'] = $authResponse["data"];
        echo "<script>";
        echo "alert('Вы успешно авторизовались')";
        echo "</script>";
    }
}

var_dump($_SESSION);
var_dump($_COOKIE);
var_dump('1');
