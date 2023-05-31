<?php

namespace App\core;

class User extends Model {
    protected $name;
    protected $surname;
    protected $email;
    protected $password;
    protected $enabled;
    protected $activation_code;

    public function getName () {
        return $this->name;
    }

    public function getSurname () {
        return $this->surname;
    }

    public function getEmail () {
        return $this->email;
    }

    public function getPassword () {
        return $this->password;
    }

    public function getEnabled () {
        return $this->enabled;
    }

    public function getActivationCode () {
        return $this->activation_code;
    }

    public function setName ($name) {
        $this->name = $name;
    }

    public function setSurname ($surname) {
        $this->surname = $surname;
    }

    public function setEmail ($email) {
        $this->email = $email;
    }

    public function setPassword ($password) {
        $this->password = $password;
    }

    public function setEnabled ($enabled) {
        $this->enabled = $enabled;
    }

    public function setActivationCode ($activation_code) {
        $this->activation_code = $activation_code;
    }
}

?>