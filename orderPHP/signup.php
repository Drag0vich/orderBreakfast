<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/include.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/html/signup.html';

session_start();

if (isset($_POST["email"]) && isset($_POST["pass"])) {
    $response = Order\Database::createUser($_POST["email"], $_POST["name"], $_POST["surname"], $_POST["login"], $_POST["pass"]);
    if ($response["success"]) {
        echo "<script>";
        echo "alert('Вы успешно зарегистрированы')";
        echo "</script>";
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $_SERVER["DOCUMENT_ROOT"]);
    }
}
