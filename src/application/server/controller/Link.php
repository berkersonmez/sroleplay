<?php
class C_Link {
    public static function create($page, $action, $additional = NULL)
    {
        switch ($page) {/*
            case "index":
                switch ($action) {
                    case "index":
                        if (!$additional["logout"])
                            return "http://reyti.com/anasayfa.html";
                        else
                            return "http://reyti.com/cikis.html";
                        break;
                }
                break;
            case "poll":
                switch ($action) {
                    case "add":
                        return "http://reyti.com/sor.html";
                        break;
                    case "inspect":
                        return "http://reyti.com/istatistik.html";
                        break;
                    case "question":
                        $question = Question::getByID($additional["id"]);
                        return "http://reyti.com/" . $additional["id"] . "-" . self::prepareString(mb_substr($question->text, 0, CS_Config::MAX_CHARS_IN_QUESTION_LINKS, 'UTF-8')) . "-soru.html";
                        break;
                }
                break;
            case "profile":
                switch ($action) {
                    case "inspect":
                        if (!$additional["id"])
                            return "http://reyti.com/profilim.html";
                        else
                            return "http://reyti.com/" . $additional["id"] . "-profil.html";
                        break;
                    case "options":
                        if (!$additional["return"])
                            return "http://reyti.com/seceneklerim.html";
                        else
                            return "http://reyti.com/" . $additional["return"] . "-secenekler.html";
                        break;
                    case "connect":
                        return "http://reyti.com/index.php?controller=profile&action=connect&to=" . $additional["to"];
                        break;
                    case "edit":
                        return "http://reyti.com/profilduzenle.html";
                        break;
                }
                break;
            case "message":
                switch ($action) {
                    case "list":
                        return "http://reyti.com/mesajlar.html";
                        break;
                    case "read":
                        return "http://reyti.com/" . $additional["id"] . "-mesajoku.html";
                        break;
                    case "new":
                        return "http://reyti.com/" . $additional["to"] . "-mesajyaz.html";
                        break;
                }
                break;
            case "login":
                switch ($action) {
                    case "form":
                        return "http://reyti.com/giris.html";
                        break;
                }
                break;
            case "registry":
                switch ($action) {
                    case "form":
                        return "http://reyti.com/" . $additional["with"] . "-uyeol.html";
                        break;
                    case "forgotpass":
                        return "http://reyti.com/sifremi-unuttum.html";
                        break;
                }
                break;
            case "link":
                switch ($action) {
                    case "twitter":
                        if (!$additional["do"])
                            return "http://reyti.com/index.php?controller=link&action=twitter";
                        else
                            return "http://reyti.com/index.php?controller=link&action=twitter&do=" . $additional["do"];
                        break;
                    case "facebook":
                        if (!$additional["do"])
                            return "http://reyti.com/index.php?controller=link&action=facebook";
                        else
                            return "http://reyti.com/index.php?controller=link&action=facebook&do=" . $additional["do"];
                        break;
                }
                break;
            case "info":
                switch ($action) {
                    case "agreement":
                        return "http://reyti.com/sozlesme.html";
                        break;
                    case "aboutus":
                        return "http://reyti.com/nedir.html";
                        break;
                    case "adreqform":
                        return "http://reyti.com/reklam.html";
                        break;
                    case "contactform":
                        return "http://reyti.com/iletisim.html";
                        break;
                }
                break;
            case "search":
                switch ($action) {
                    case "poll":
                        return "http://reyti.com/ara.html";
                        break;
                }
                break;
            case "logout":
                switch ($action) {
                    case "logout":
                        return "http://reyti.com/cik.html";
                        break;
                }
                break;*/
            default:
                $link = "/index.php?page=" . $page . "&action=" . $action;
                if ($additional) {
                    foreach ($additional as $add1 => $add2) {
                        $link .= "&" . $add1 . "=" . $add2;
                    }
                }
                return $link;
                break;
        }
    }
}