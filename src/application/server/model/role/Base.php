<?php

abstract class M_Role_Base extends M_Model {

    protected $id;
    protected $name;
    protected $accessiblePages = array();

    public function getID(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function canAccessPage($pageName){
        return in_array($pageName, (array)$this->accessiblePages);
    }

    public function canAccessManagementPanel() {return $this->canAccessPage("management");}
}