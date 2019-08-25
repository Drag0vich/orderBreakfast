<?php

namespace Order;
require_once $_SERVER['DOCUMENT_ROOT'] . '/include.php';

Class Database {
    public static function getUserInfoById($id) {
        $res = [
            "success" => false,
            "message" => "Unknown error in Database.getUserInfoById"
        ];

        $mysqli = new \mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if ($mysqli->connect_errno) {
            $res["message"] = "Connect Error (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            return $res;
        }

        $id = $mysqli->real_escape_string($id);

        $sql = 'SELECT *
                FROM user_info
                WHERE ID = "' . $id . '"';

        if (!$result = $mysqli->query($sql)) {
            $res["message"] = "SQL:\n" . $sql . "\n Num error: " . $mysqli->connect_errno . "\n" . $mysqli->connect_error;
            return $res;
        }

        if ($result->num_rows === 0) {
            $res["message"] = "User does not exist";
            return $res;

        }

        $user = User::fromArray($result->fetch_assoc());

        $res = [
            "success" => true,
            "message" => "OK",
            "data" => $user
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
            $res["message"] = "Connect Error (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

        $log = $mysqli->real_escape_string($log);
        $pass = $mysqli->real_escape_string($pass);

        $sql = 'SELECT *
                FROM user_info
                WHERE LOGIN = "' . $log . '"
                    OR EMAIL = "' . $log . '"
                    AND PASS = "' . MD5($pass) . '"';

        if (!$result = $mysqli->query($sql)) {
            $res["message"] = "SQL:\n" . $sql . "\n Num error: " . $mysqli->connect_errno . "\n" . $mysqli->connect_error;
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
            $res["message"] = "Connect Error (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            return $res;
        }

        $id = $mysqli->real_escape_string($id);

        $sql = 'SELECT *
                FROM user_permissions
                WHERE ID = "' . $id . '"';

        if (!$result = $mysqli->query($sql)) {
            $res["message"] = "SQL:\n" . $sql . "\n Num error: " . $mysqli->connect_errno . "\n" . $mysqli->connect_error;
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
            $res["message"] = "Connect Error (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            return $res;
        }

        $timestamp = date("Y-m-d H:i:s");

        $email = $mysqli->real_escape_string($email);
        $name = $mysqli->real_escape_string($name);
        $surname = $mysqli->real_escape_string($surname);
        $login = $mysqli->real_escape_string($login);
        $password = $mysqli->real_escape_string($password);


        $sql = 'INSERT INTO user_info (GIVEN_NAME, FAMILY_NAME, EMAIL, LOGIN, DATE_REGISTER, PASS)
                    VALUE ("' . $name . '", "' . $surname . '", "' . $email . '", "' . $login . '", "' . $timestamp . '", "' . MD5($password) . '")';

        if ($mysqli->query($sql)) {
            $sql = 'SELECT *
                FROM user_info
                WHERE EMAIL = "' . $email . '"';

            $userId = $mysqli->query($sql)->fetch_assoc()["ID"];

            $sql = 'INSERT INTO user_permissions (ID)
                    VALUE ("' . $userId . '")';
            $mysqli->query($sql);
        } else {
            $res["message"] = "SQL:\n" . $sql . "\n Num error: " . $mysqli->connect_errno . "\n" . $mysqli->connect_error;
        }

        $res = [
            "success" => true,
            "message" => "OK"
        ];

        return $res;
    }

    public static function addSessionInfo($userId) {
        $res = [
            "success" => false,
            "message" => "Unknown error in Database.addSessionInfo"
        ];

        $mysqli = new \mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if ($mysqli->connect_errno) {
            $res["message"] = "Connect Error (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            return $res;
        }

        $timestamp = date("Y-m-d H:i:s");

        $userId = $mysqli->real_escape_string($userId);
        $sessionId = $mysqli->real_escape_string($_COOKIE["PHPSESSID"]);
        $userAgent = $mysqli->real_escape_string($_SERVER["HTTP_USER_AGENT"]);
        $ipAddress = $mysqli->real_escape_string($_SERVER["HTTP_CLIENT_IP"]);

        $sql = 'INSERT INTO user_info (ID, SESSION_ID, USER_AGENT, IP_ADDRESS, LAST_LOGIN)
                    VALUE ("' . $userId . '", "' . $sessionId . '", "' . $userAgent . '", "' . $ipAddress . '", "' . $timestamp . '")';

        if (!$result = $mysqli->query($sql)) {
            $res["message"] = "SQL:\n" . $sql . "\n Num error: " . $mysqli->connect_errno . "\n" . $mysqli->connect_error;
            return $res;
        }

        $res = [
            "success" => true,
            "message" => "OK"
        ];

        return $res;
    }

    public static function updateUser($user) {
        $res = [
            "success" => false,
            "message" => "Unknown error in Database.addSessionInfo"
        ];

        if ($user->getId() == null) {
            return self::createUser($user->getEmail(), $user->getName(), $user->getSurname(), $user->getLogin(), $user->getPassword());
        } else {
            $mysqli = new \mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

            if ($mysqli->connect_errno) {
                $res["message"] = "Connect Error (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
                return $res;
            }

            $id = $mysqli->real_escape_string($user->getId());
            $email = $mysqli->real_escape_string($user->getEmail());
            $name = $mysqli->real_escape_string($user->getName());
            $surname = $mysqli->real_escape_string($user->getSurname());
            $login = $mysqli->real_escape_string($user->getLogin());
            $pass = $mysqli->real_escape_string(md5($user->getPassword()));

            $sql = 'UPDATE user_info
                    SET GIVEN_NAME = "' . $name . '",
                        FAMILY_NAME = "' . $surname . '",
                        EMAIL = "' . $email . '",
                        LOGIN = "' . $login . '",
                        PASS = "' . $pass . '"
                    WHERE ID = "' . $id . '"';

            if (!$result = $mysqli->query($sql)) {
                $res["message"] = "SQL:\n" . $sql . "\n Num error: " . $mysqli->connect_errno . "\n" . $mysqli->connect_error;
                return $res;
            }

            $res = [
                "success" => true,
                "message" => "OK"
            ];
        }
        return $res;
    }

    public static function removeUser(&$user) {
        $res = [
            "success" => false,
            "message" => "Unknown error in Database.removeUser"
        ];

        $mysqli = new \mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if ($mysqli->connect_errno) {
            $res["message"] = "Connect Error (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            return $res;
        }

        $userId = $mysqli->real_escape_string($user->getId());

        $sql = 'DELETE
                FROM user_info
                WHERE ID = "' . $userId . '"';

        if ($mysqli->query($sql)) {
            $sql = 'DELETE
                    FROM user_auth_log
                    WHERE ID = "' . $userId . '"';

            $mysqli->query($sql);

            $sql = 'DELETE
                    FROM user_permission
                    WHERE ID = "' . $userId . '"';

            $mysqli->query($sql);
        } else {
            $res["message"] = "SQL:\n" . $sql . "\n Num error: " . $mysqli->connect_errno . "\n" . $mysqli->connect_error;
            return $res;
        }

        $res = [
            "success" => true,
            "message" => "OK"
        ];

        return $res;
    }
}
