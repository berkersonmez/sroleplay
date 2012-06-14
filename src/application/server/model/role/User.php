<?php

class M_Role_User extends M_Role_Base {

    public function __construct() {

        $this->id = 2;
        $this->name = "User";
        $this->accessiblePages = array("index", "ajax", "logout");
    }

}