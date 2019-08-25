<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/include.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/html/index.html';

session_start();

if (isset($_POST["email"]) && isset($_POST["pass"])) {
    $authResponse = Order\Session::checkAuthData($_POST["email"], $_POST["pass"]);
    Order\Utils::dump($authResponse);
    if ($authResponse["success"]) {
        echo "<script>";
        echo "alert('Вы успешно авторизовались')";
        echo "</script>";
    }
}
