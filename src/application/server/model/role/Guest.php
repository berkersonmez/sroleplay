<?php

class M_Role_Guest extends M_Role_Base {

    public function __construct() {
        $this->id = 1;
        $this->name = "Guest";
        $this->accessiblePages = array("index","registry", "login", "ajax");
    }

}