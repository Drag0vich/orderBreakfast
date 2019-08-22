<?php

namespace Order;
require_once $_SERVER['DOCUMENT_ROOT'] . '/define.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

Class Database {
    public static function getUserInfoById($id) {
        $res = [
            "success" => false,
            "message" => "Unknown error in Database.getUserInfoById"
        ];

        $mysqli = new \mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if ($mysqli->connect_errno) {
            $res["message"] = 'Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
            return $res;
        }

        $sql = 'SELECT *
                FROM user_info
                WHERE ID = "' . $id . '"';

        if (!$result = $mysqli->query($sql)) {
            $res["message"] = 'SQL = (' . $sql . ') Num error = (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
            return $res;
        }

        if ($result->num_rows === 0) {
            $res["message"] = "User does not exist";
            return $res;

        }

        $res = [
            "success" => true,
            "message" => "OK",
            "data" => $result->fetch_assoc()
        ];

        return $res;
    }

    public static function checkAuthData($log, $pass) {
        $res = [
            "success" => false,
            "message" => "Unknown error in Database.getUserInfoById"
        ];

        Utils::dump(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $mysqli = new \mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if ($mysqli->connect_errno) {
            $res["message"] = 'Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
        }

        $sql = 'SELECT user_authorize.ID
                FROM user_authorize
                         LEFT JOIN
                     user_info ON user_authorize.ID = user_info.ID
                WHERE user_authorize.LOGIN = "' . $log . '" AND user_authorize.PASS = "' . MD5($pass) . '"
                   OR user_info.EMAIL = "' . $log . '" AND user_authorize.PASS = "' . MD5($pass) . '"';

        if (!$result = $mysqli->query($sql)) {
            Utils::dump($mysqli->query($sql));
            $res["message"] = 'SQL = (' . $sql . ') Num error = (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
            return $res;
        }

        if ($result->num_rows === 0) {
            $res["message"] = "User does not exist";
            return $res;

        }

        $res = [
            "success" => true,
            "message" => "OK",
            "data" => $result->fetch_assoc()["ID"]
        ];

        return $res;
    }

    public static function getPermissionsById($id) {
        $res = [
            "success" => false,
            "message" => "Unknown error in Database.getUserInfoById"
        ];

        $mysqli = new \mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if ($mysqli->connect_errno) {
            $res["message"] = 'Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
            return $res;
        }

        $sql = 'SELECT *
                FROM user_permissions
                WHERE ID = "' . $id . '"';

        if (!$result = $mysqli->query($sql)) {
            $res["message"] = 'SQL = (' . $sql . ') Num error = (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
            return $res;
        }

        if ($result->num_rows === 0) {
            $res["message"] = "User does not exist";
            return $res;
        }

        $res = [
            "success" => true,
            "message" => "OK",
            "data" => $result->fetch_assoc()
        ];

        return $res;
    }

    public static function createUser($email, $name = "", $surname = "", $login = "", $password) {
        $res = [
            "success" => false,
            "message" => "Unknown error in Database.createUser"
        ];

        $mysqli = new \mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if ($mysqli->connect_errno) {
            $res["message"] = 'Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
            return $res;
        }

        $timestamp = date("Y-m-d H:i:s");

        $sql = 'INSERT INTO user_info (GIVEN_NAME, FAMILY_NAME, EMAIL, USERNAME, TIMESTAMP)
                    VALUE ("' . $name . '", "' . $surname . '", "' . $email . '", "' . $login . '", "' . $timestamp . '")';

        if ($mysqli->query($sql)) {
            $sql = 'SELECT *
                FROM user_info
                WHERE EMAIL = "' . $email . '"';

            $userId = $mysqli->query($sql)->fetch_assoc()["ID"];

            $sql = 'INSERT INTO user_authorize (ID, LOGIN, PASS)
                    VALUE ("' . $userId . '", "' . $login . '", "' . MD5($password) . '")';
            $mysqli->query($sql);

            $sql = 'INSERT INTO user_permissions (ID)
                    VALUE ("' . $userId . '")';
            $mysqli->query($sql);
        } else {
            $res["message"] = 'SQL = (' . $sql . ') Num error = (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
        }

        $res = [
            "success" => true,
            "message" => "OK"
        ];

        return $res;
    }

    /**
     * @param $userId =
     * @param $sessionId = $_COOKIE["PHPSESSID"]
     * @param $userAgent = $_SERVER["HTTP_USER_AGENT"]
     * @param $ipAddress =
     */
    public static function addSessionInfo($userId, $sessionId, $userAgent, $ipAddress) {

    }
}
