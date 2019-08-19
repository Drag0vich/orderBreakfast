<?php

foreach (glob($_SERVER['DOCUMENT_ROOT'] . "/classes/*.php") as $filename) {
    require_once $filename;
}

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/html/index.html';

if (isset($_POST["email"]) && isset($_POST["pass"])) {
    $authResponse = classes\Database::checkAuthData($_POST["email"], $_POST["pass"]);
    if ($authResponse["success"]) {
        $_SESSION['userId'] = $authResponse["data"];
        echo "<script>";
        echo "alert('Вы успешно авторизовались')";
        echo "</script>";
    }
}
