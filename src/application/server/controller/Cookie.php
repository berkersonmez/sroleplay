<?php
class C_Cookie {

    public static function setRememberCookie(M_User_Regular $user, $authSecret) {
        $cookieHash = C_Security_Validation::getCookieHash($user->getPassword(), $authSecret);
        $user->updateCookieHash($cookieHash);
        setcookie('userRemembered', $cookieHash, time() + C_Config::USER_REMEMBER_COOKIE_TIME);
    }
}