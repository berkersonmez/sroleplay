<?php

class M_User_Guest extends M_Model {
    private $role;
    private $ip;

    public function __construct() {
        $this->maintainRole();
        $this->ip = $_SERVER['REMOTE_ADDR'];
    }

    public function maintainRole() {
        $this->role = new M_Role_Guest();
    }

    public function getRole() {
        return $this->role;
    }
}