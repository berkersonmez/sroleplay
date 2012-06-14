<?php
require_once('../server/controller/Config.php');
class C_Main extends C_Config {
    const DIR_SRC = '../..';

    public static function getDirApplication()
    {
        return self::DIR_SRC . '/application';
    }

    public static function getDirPublic()
    {
        return self::DIR_SRC . '/application/public';
    }

    public static function getDirServer()
    {
        return self::DIR_SRC . '/application/server';
    }

    public static function getDirController()
    {
        return self::DIR_SRC . '/application/server/controller';
    }

    public static function getDirModel()
    {
        return self::DIR_SRC . '/application/server/model';
    }

    public static function getDirView()
    {
        return self::DIR_SRC . '/application/server/view';
    }

    public static function getDirLayout()
    {
        return self::DIR_SRC . '/application/server/view/layout';
    }

    public static function getDirPage()
    {
        return self::DIR_SRC . '/application/server/view/page';
    }

    public static function getDirLibrary()
    {
        return self::DIR_SRC . '/library';
    }

    public static function getDirLibraryCustom()
    {
        return self::DIR_SRC . '/library/custom';
    }

    public static function getDirLibraryReady()
    {
        return self::DIR_SRC . '/library/ready';
    }

    public static function getDirStyle()
    {
        return self::DIR_SRC . '/application/public/style';
    }

    public static function getDirStyleImg()
    {
        return './style/img';
    }

    /*public static function getDirUpload()
    {
        return self::DIR_SRC . '/application/public/upload';
    }*/

    public static function getDirSkin()
    {
        return './style/img/skin';
    }

    public static function loadClass($className) {
        $classNameParts = explode("_", $className);
        if ($classNameParts[0] == 'C') {$classNameParts[0] = 'controller';}
        else if ($classNameParts[0] == 'M') {$classNameParts[0] = 'model';}
        $classDir = self::getDirServer();
        for ($i = 0; $i < count($classNameParts); $i++) {
            $classDir.= '/' . ($i == count($classNameParts)-1 ? $classNameParts[$i] : strtolower($classNameParts[$i]));
        }
        require_once($classDir . '.php');
    }

    public static function setErrorReportings() {
        error_reporting(E_ALL ^ E_NOTICE);
        ini_set('display_errors', 1);
    }

    public static function setDefaultTimezone()
    {
        date_default_timezone_set('Europe/Istanbul');
    }

    public static function getPage()
    {
        return (!empty($_GET['page'])) ? trim($_GET['page']) : 'index';
    }

    public static function getAction()
    {
        return (!empty($_GET['action'])) ? trim($_GET['action']) : 'index';
    }

    public static function init() {
        self::setErrorReportings();
        self::setDefaultTimezone();
        if (self::getPage() == "ajax") {
            C_Layout::render("AJAX");
        } else {
            C_Layout::render("HTML");
        }
    }

}