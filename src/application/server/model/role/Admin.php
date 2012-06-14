<?php

class M_Role_Admin extends M_Role_User {

    public function __construct() {
        parent::__construct();
        $this->id = 4;
        $this->name = "Admin";
        array_push($this->accessiblePages, "management");
    }

}