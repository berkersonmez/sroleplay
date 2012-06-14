<?php

abstract class M_DBModel
{
    protected static $_dbo;
    public function __construct() {
        self::$_dbo = C_Database_Handler::getDBO();
    }
    protected abstract function initWithID($id);
    protected function initSelf($data) {
        foreach ($data as $propName => $propValue)
        {
            $this->{$propName} = $propValue;
        }
    }
}