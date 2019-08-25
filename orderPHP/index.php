<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/include.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/html/index.html';

session_start();

if (isset($_POST["email"]) && isset($_POST["pass"])) {
    $authResponse = Order\Database::checkAuthData($_POST["email"], $_POST["pass"]);
    if ($authResponse["success"]) {
        $_SESSION['userId'] = $authResponse["data"];
        $_COOKIE['userId'] = $authResponse["data"];
        echo "<script>";
        echo "alert('Вы успешно авторизовались')";
        echo "</script>";
    }
}

