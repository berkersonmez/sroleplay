<?php
class C_Session {

    private static $user = null;

    public static function getUser()
    {
        return self::$user;
    }

    public static function setUser($user)
    {
        self::$user = $user;
    }
    public static function isEmpty() {
        return ((self::$user == null) || (get_class(self::$user) == "M_User_Guest"));
    }

    public static function createAjaxRequestKey() {
        $aRK = md5(rand(100, 10000));
        $_SESSION['ARK'] = $aRK;
        return $aRK;
    }

    public static function controlAjaxRequestKey($key) {
        return $_SESSION['ARK'] == $key;
    }

    public static function killAjaxRequestKey() {
        $_SESSION['ARK'] = md5(rand(10000, 10000000));
    }
}