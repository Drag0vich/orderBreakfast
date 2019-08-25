<?php

namespace Order;
require_once $_SERVER['DOCUMENT_ROOT'] . '/include.php';

class User implements Save, Entity {
    protected $id = null;
    protected $name = "";
    protected $surname = "";
    protected $email = "";
    protected $username = "";
    protected $password = "";

    function __construct() {
        $this->id = null;
        $this->name = "";
        $this->surname = "";
        $this->email = "";
        $this->username = "";
        $this->password = "";

    }

    function __destruct() {

    }

    static function fromArray($array) {
        $user = null;
        if ($array) {
            $user = new User();
            $user->setId($array["ID"]);
            $user->setName($array["NAME"]);
            $user->setSurname($array["SURNAME"]);
            $user->setEmail($array["EMAIL"]);
            $user->setUsername($array["USERNAME"]);
            $user->setPassword($array["PASSWORD"]);
        }
        return $user;
    }

    public function toArray() {
        $user = array(
            "id" => $this->getId(),
            "name" => $this->getName(),
            "surname" => $this->getSurname(),
            "email" => $this->getEmail(),
            "username" => $this->getUsername(),
            "password" => $this->getPassword(),
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
        $this->surname = (int)$surname;
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

    function setUsername($username) {
        $this->username = $username;
    }

    function getUsername() {
        return $this->username;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function getPassword() {
        return $this->password;
    }

    public function save() {
        Database::updateUser($this);
    }

    public function remove() {
        Database::removeUser($this);
    }
}
