<?php
ob_start();
session_start();

require_once('../server/controller/Main.php');

function __autoload($className)
{
    C_Main::loadClass($className);
}

C_Main::init();

ob_flush();