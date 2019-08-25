<?php

namespace Order;
require_once $_SERVER['DOCUMENT_ROOT'] . '/include.php';

class Session {
    public static function checkAuthData($log, $pass) {
        $res = [
            "success" => false,
            "message" => "Unknown error in Session.checkAuthData"
        ];

        $response = Database::checkAuthData($log, $pass);

        if ($response["success"]) {
            $user = Database::getUserInfoById($response["data"])["data"];
            self::startSession($user);
            $res = [
                "success" => true,
                "message" => "ok",
                "data" => $user
            ];
        } else {
            $res = $response;
        }
        return $res;
    }

    public static function startSession($user) {
        $_SESSION['userId'] = $user->getId();
        $_COOKIE['userId'] = $user->getId();
    }

    public static function removeSession() {
        unset($_SESSION['userId']);
        unset($_COOKIE['userId']);
    }
}
