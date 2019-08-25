<?php

namespace Order;
require_once $_SERVER['DOCUMENT_ROOT'] . '/include.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/interface/entity.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/interface/save.php';

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

        $sql = $mysqli->real_escape_string($sql);

        if (!$result = $mysqli->query($sql)) {
            $res["message"] = 'SQL:\n' . $sql . '\n Num error:\n' . $mysqli->connect_errno . '\n' . $mysqli->connect_error;
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

        $sql = $mysqli->real_escape_string($sql);

        if (!$result = $mysqli->query($sql)) {
            $res["message"] = 'SQL:\n' . $sql . '\n Num error:\n' . $mysqli->connect_errno . '\n' . $mysqli->connect_error;
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

        $sql = $mysqli->real_escape_string($sql);

        if (!$result = $mysqli->query($sql)) {
            $res["message"] = 'SQL:\n' . $sql . '\n Num error:\n' . $mysqli->connect_errno . '\n' . $mysqli->connect_error;
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

        $sql = $mysqli->real_escape_string($sql);

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
            $res["message"] = 'SQL:\n' . $sql . '\n Num error:\n' . $mysqli->connect_errno . '\n' . $mysqli->connect_error;
        }

        $res = [
            "success" => true,
            "message" => "OK"
        ];

        return $res;
    }

    /**
     * @param $userId    =
     * @param $sessionId = $_COOKIE["PHPSESSID"]
     * @param $userAgent = $_SERVER["HTTP_USER_AGENT"]
     * @param $ipAddress = $_SERVER["HTTP_CLIENT_IP"]
     */
    public static function addSessionInfo($userId, $sessionId, $userAgent, $ipAddress) {
        $res = [
            "success" => false,
            "message" => "Unknown error in Database.addSessionInfo"
        ];

        $mysqli = new \mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if ($mysqli->connect_errno) {
            $res["message"] = 'Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
            return $res;
        }

        $timestamp = date("Y-m-d H:i:s");

        $sql = 'INSERT INTO user_info (ID, SESSION_ID, USER_AGENT, IP_ADDRESS, TIMESTAMP)
                    VALUE ("' . $userId . '", "' . $sessionId . '", "' . $userAgent . '", "' . $ipAddress . '", "' . $timestamp . '")';

        $sql = $mysqli->real_escape_string($sql);

        if (!$result = $mysqli->query($sql)) {
            $res["message"] = 'SQL:\n' . $sql . '\n Num error:\n' . $mysqli->connect_errno . '\n' . $mysqli->connect_error;
            return $res;
        }

        $res = [
            "success" => true,
            "message" => "OK"
        ];

        return $res;
    }

    public static function removeUser(&$user) {
        $res = [
            "success" => false,
            "message" => "Unknown error in Database.removeUser"
        ];

        $mysqli = new \mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if ($mysqli->connect_errno) {
            $res["message"] = 'Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
            return $res;
        }

        $sql = 'DELETE
                FROM user_info
                WHERE ID = "' . $user->getId() . '"';

        $sql = $mysqli->real_escape_string($sql);

        if ($mysqli->query($sql)) {
            $sql = 'DELETE
                    FROM user_auth_log
                    WHERE ID = "' . $user->getId() . '"';

            $sql = $mysqli->real_escape_string($sql);
            $mysqli->query($sql);

            $sql = 'DELETE
                    FROM user_authorize
                    WHERE ID = "' . $user->getId() . '"';

            $sql = $mysqli->real_escape_string($sql);
            $mysqli->query($sql);

            $sql = 'DELETE
                    FROM user_permission
                    WHERE ID = "' . $user->getId() . '"';

            $sql = $mysqli->real_escape_string($sql);
            $mysqli->query($sql);
        } else {
            $res["message"] = 'SQL:\n' . $sql . '\n Num error:\n' . $mysqli->connect_errno . '\n' . $mysqli->connect_error;
            return $res;
        }

        $res = [
            "success" => true,
            "message" => "OK"
        ];

        return $res;
    }
}
