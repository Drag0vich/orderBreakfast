<?php

foreach (glob($_SERVER['DOCUMENT_ROOT'] . "/classes/*.php") as $filename) {
    require_once $filename;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/html/signup.html';
if (isset($_POST["email"]) && isset($_POST["pass"])) {
    $response = classes\Database::createUser($_POST["email"], $_POST["name"], $_POST["surname"], $_POST["login"], $_POST["pass"]);
    if ($response["success"]) {
        echo "<script>";
        echo "alert('Вы успешно зарегистрированы')";
        echo "</script>";
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $_SERVER["DOCUMENT_ROOT"]);
    }
}
