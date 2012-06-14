<?php
class C_Security_Validation {

    private static $errorMessage;

    public static function getCookieHash($password, $authSecret) {
        return md5($password . $authSecret . rand(0, 1000));
    }

    public static function validateGeneral($string, $fieldName) {
        if ($string == "") {
            self::$errorMessage = $fieldName . C_T::_(" boş bırakılamaz!");
            return false;
        }
        return true;
    }

    public static function validatePass($password) {
        if (mb_strlen($password, 'UTF-8') < C_Config::MIN_LENGTH_PASSWORD) {
            self::$errorMessage = C_T::_("Şifre " .C_Config::MIN_LENGTH_PASSWORD. " karakterden kısa olamaz!");
            return false;
        }
        if (mb_strlen($password, 'UTF-8') > C_Config::MAX_LENGTH_PASSWORD) {
            self::$errorMessage = C_T::_("Şifre " .C_Config::MAX_LENGTH_PASSWORD. " karakterden uzun olamaz!");
            return false;
        }
        return true;
    }

    public static function validateEmail($email) {
        if (mb_strlen($email, 'UTF-8') < C_Config::MIN_LENGTH_EMAIL) {
            self::$errorMessage = C_T::_("E-mail adresi " .C_Config::MIN_LENGTH_EMAIL. " karakterden kısa olamaz!");
            return false;
        }
        if (mb_strlen($email, 'UTF-8') > C_Config::MAX_LENGTH_EMAIL) {
            self::$errorMessage = C_T::_("E-mail adresi " .C_Config::MAX_LENGTH_EMAIL. " karakterden uzun olamaz!");
            return false;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            self::$errorMessage = C_T::_("E-mail adresi geçersiz!");
            return false;
        }
        if (C_Database_SQL::executeSQL(C_Database_Handler::getDBO(), C_Database_SQL::getSelectQuery1Where1Limit("id", "User", "email", 1), array($email)))
        {
            self::$errorMessage = C_T::_("Bu e-mail ile kayıtlı üye var!");
            return false;
        }
        return true;
    }

    public static function validateName($name) {
        if (mb_strlen($name, 'UTF-8') < C_Config::MIN_LENGTH_NAME) {
            self::$errorMessage = C_T::_("Ad soyad " .C_Config::MIN_LENGTH_NAME. " karakterden kısa olamaz!");
            return false;
        }
        if (mb_strlen($name, 'UTF-8') > C_Config::MAX_LENGTH_NAME) {
            self::$errorMessage = C_T::_("Ad soyad " .C_Config::MAX_LENGTH_NAME. " karakterden uzun olamaz!");
            return false;
        }
        return true;
    }

    public static function validateAge($age) {
        if ($age < C_Config::MIN_AGE) {
            self::$errorMessage = C_T::_("Yaş en az " .C_Config::MIN_AGE. " olabilir!");
            return false;
        }
        if ($age > C_Config::MAX_AGE) {
            self::$errorMessage = C_T::_("Yaş en çok " .C_Config::MAX_AGE. " olabilir!");
            return false;
        }
        return true;
    }

    public static function validateBio($bio) {
        if (mb_strlen($bio, 'UTF-8') < C_Config::MIN_LENGTH_BIO) {
            self::$errorMessage = C_T::_("Biyografi " .C_Config::MIN_LENGTH_BIO. " karakterden kısa olamaz!");
            return false;
        }
        if (mb_strlen($bio, 'UTF-8') > C_Config::MAX_LENGTH_BIO) {
            self::$errorMessage = C_T::_("Biyografi " .C_Config::MAX_LENGTH_BIO. " karakterden uzun olamaz!");
            return false;
        }
        return true;
    }

    public static function validateUsername($username) {
        if (mb_strlen($username, 'UTF-8') < C_Config::MIN_LENGTH_USERNAME) {
            self::$errorMessage = C_T::_("Kullanıcı adı " .C_Config::MIN_LENGTH_USERNAME. " karakterden kısa olamaz!");
            return false;
        }
        if (mb_strlen($username, 'UTF-8') > C_Config::MAX_LENGTH_USERNAME) {
            self::$errorMessage = C_T::_("Kullanıcı adı " .C_Config::MAX_LENGTH_USERNAME. " karakterden uzun olamaz!");
            return false;
        }
        if (C_Database_SQL::executeSQL(C_Database_Handler::getDBO(), C_Database_SQL::getSelectQuery1Where1Limit("id", "User", "username", 1), array($username)))
        {
            self::$errorMessage = C_T::_("Bu kullanıcı adı ile kayıtlı üye var!");
            return false;
        }
        return true;
    }

    public static function validateBirthday($birthday) {
        $bParts = explode("-", $birthday);
        if ($bParts[2] < 1 || $bParts[2] > 31 || $bParts[1] < 1 || $bParts[1] > 12 || $bParts[0] < 1800 || $bParts[0] > 2100) {
            self::$errorMessage = C_T::_("Doğum tarihi geçersiz.");
            return false;
        }
        return true;
    }

    public static function getErrorMessage()
    {
        return self::$errorMessage;
    }
}