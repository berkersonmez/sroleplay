<?php
class C_Security_Authenticate {
    private static $authSecret = "1nf0gy392hfoa8gty1itgd8dca7nb5";

    public static function login($emailOrUsername, $password, $remember=false) {
        $emailOrUsername = C_Security_Filter::queryFilter(C_Security_Filter::stringFilter($emailOrUsername));
        $password = C_Security_Filter::cryptPassword($password);
        if (!self::loginControl()) {
            $user = new M_User_Regular();
            if ($user->initWithUsernameOrEmailAndPass($emailOrUsername, $password)) {
                C_Session::setUser($user);
                $_SESSION['userLoggedIn'] = true;
                $_SESSION['userID'] = $user->getID();
                return true;
            }
        }
        return false;
    }

    public static function logout() {
        if (self::loginControl()) {
            setcookie('userRemembered', "", time() - 3600);
            if (isset($_SESSION['userLoggedIn'])) {
                unset($_SESSION['userLoggedIn']);
                $_SESSION['userID'] = "logout";
                return true;
            }
        }
        return false;
    }

    public static function loginWithApprovedUser(M_User_Base $user) {
        $_SESSION['userLoggedIn'] = true;
        $_SESSION['userID'] = $user->getID();
        C_Session::setUser($user);
    }

    public static function loginControl() {
        if (C_Session::isEmpty()) {
            if (isset($_SESSION['userLoggedIn']) && isset($_SESSION['userID'])) {
                $user = new M_User_Regular();
                if ($user->initWithID($_SESSION['userID'])) {
                    C_Session::setUser($user);
                    return true;
                }
                unset($_SESSION['userLoggedIn']);
                unset($_SESSION['userID']);
                setcookie('userRemembered', "", time() - 3600);
            } else {
                // remember logic.
            }
            C_Session::setUser(new M_User_Guest());
            setcookie('userRemembered', "", time() - 3600);
            return false;
        }
        return true;
    }

    public static function auth($forcedLayoutName = '') {
        self::loginControl();
        $user = C_Session::getUser();
        $role = $user->getRole();
        if ($role->canAccessPage(C_Main::getPage())) {return true;}
        return false;
    }

}