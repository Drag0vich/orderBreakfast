<?php

//foreach (glob($_SERVER['DOCUMENT_ROOT'] . "/classes/*.php") as $filename) {
//    require_once $filename;
//}
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

session_start();


require_once $_SERVER['DOCUMENT_ROOT'] . '/html/index.html';

if (isset($_POST["email"]) && isset($_POST["pass"])) {
    $authResponse = Order\Database::checkAuthData($_POST["email"], $_POST["pass"]);
    var_dump($authResponse);
    if ($authResponse["success"]) {
        $_SESSION['userId'] = $authResponse["data"];
        echo "<script>";
        echo "alert('Вы успешно авторизовались')";
        echo "</script>";
    }
}
