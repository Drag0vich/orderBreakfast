<?php

namespace classes;
require_once $_SERVER['DOCUMENT_ROOT'] . '/define.php';

Class Database {
    public static function getUserInfoById($id) {
        $res = [
            "success" => false,
            "message" => "Unknown error in Database.getUserInfoById"
        ];

        $mysqli = new \mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if ($mysqli->connect_errno) {
            return $res["message"] = 'Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
        }

        $sql = "SELECT *
                FROM user_info
                WHERE ID = $id";

        if (!$result = $mysqli->query($sql)) {
            return $res["message"] = 'SQL = (' . $sql . ') Num error = (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
        }

        if ($result->num_rows === 0) {
            return $res["message"] = "User does not exist";
        }

        $res = [
            "success" => true,
            "message" => "ok",
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

        $sql = "SELECT user_authorize.ID AS ID
                FROM user_authorize
                         LEFT JOIN
                     user_info ON user_authorize.ID = user_info.ID
                WHERE user_authorize.LOGIN = $log AND user_authorize.PASS = $pass
                   OR user_info.EMAIL = $log AND user_authorize.PASS = $pass";

        if (!$result = $mysqli->query($sql)) {
            return $res["message"] = 'SQL = (' . $sql . ') Num error = (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
        }

        if ($result->num_rows === 0) {
            return $res["message"] = "User does not exist";
        }

        $res = [
            "success" => true,
            "message" => "ok",
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
            return $res["message"] = 'Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
        }

        $sql = "SELECT *
                FROM user_permissions
                WHERE ID = $id";

        if (!$result = $mysqli->query($sql)) {
            return $res["message"] = 'SQL = (' . $sql . ') Num error = (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
        }

        if ($result->num_rows === 0) {
            return $res["message"] = "User does not exist";
        }

        $res = [
            "success" => true,
            "message" => "ok",
            "data" => $result->fetch_assoc()
        ];

        return $res;
    }
}
