<?php

namespace Order;
require_once $_SERVER['DOCUMENT_ROOT'] . '/include.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/interface/entity.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/interface/save.php';

class User implements Save, Entity {
    protected $id = null;
    protected $name = "";
    protected $surname = "";
    protected $email = "";
    protected $login = "";
    protected $password = "";
    protected $dateRegister = null;

    function __construct() {
        $this->id = null;
        $this->name = "";
        $this->surname = "";
        $this->email = "";
        $this->login = "";
        $this->password = "";
        $this->dateRegister = null;
    }

    function __destruct() {

    }

    static function fromArray($array) {
        $user = null;
        if ($array) {
            $user = new User();
            $user->setId($array["ID"]);
            $user->setName($array["GIVEN_NAME"]);
            $user->setSurname($array["FAMILY_NAME"]);
            $user->setEmail($array["EMAIL"]);
            $user->setLogin($array["LOGIN"]);
            $user->setPassword($array["PASS"]);
            $user->setDateRegister($array["DATE_REGISTER"]);
        }
        return $user;
    }

    public function toArray() {
        $user = array(
            "id" => $this->getId(),
            "name" => $this->getName(),
            "surname" => $this->getSurname(),
            "email" => $this->getEmail(),
            "login" => $this->getLogin(),
            "password" => $this->getPassword(),
            "date_register" => $this->getDateRegister(),
        );
        return $user;
    }

    function setId($id) {
        $this->id = (int)$id;
    }

    function getId() {
        return (int)$this->id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function getName() {
        return $this->name;
    }

    function setSurname($surname) {
        $this->surname = $surname;
    }

    function getSurname() {
        return $this->surname;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function getEmail() {
        return $this->email;
    }

    function setLogin($login) {
        $this->login = $login;
    }

    function getLogin() {
        return $this->login;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function getPassword() {
        return $this->password;
    }

    function setDateRegister($datetime) {
        $this->dateRegister = $datetime;
    }

    function getDateRegister() {
        return $this->dateRegister;
    }

    public function save() {
        Database::updateUser($this);
    }

    public function remove() {
        Database::removeUser($this);
    }
}
