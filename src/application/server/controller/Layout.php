<?php
class C_Layout {

    private static $layoutList = array("ajax");

    public static function render($type, $forcedLayoutName = '') {
        $headerTop = '';
        $footerEnd = '';
        $layoutFolderName = 'default';
        if ($type == "HTML") {
            $headerTop = '
            <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
            ';
            $footerEnd = '</html>';
        }
        if (in_array(C_Main::getPage(),self::$layoutList)) {
            $layoutFolderName = C_Main::getPage();
        }
        if ($forcedLayoutName) {
            $layoutFolderName = $forcedLayoutName;
        }
        print($headerTop);
        require_once(C_Main::getDirLayout() . '/' . $layoutFolderName . '/header.phtml');
        if (C_Security_Authenticate::auth($layoutFolderName)) {
            require_once(C_Main::getDirPage() . '/' . C_Main::getPage() . '/' . C_Main::getAction() . '.phtml');
        } else {
            require_once(C_Main::getDirLayout() . '/' . $layoutFolderName . '/restricted.phtml');
        }
        require_once(C_Main::getDirLayout() . '/' . $layoutFolderName . '/right.phtml');
        require_once(C_Main::getDirLayout() . '/' . $layoutFolderName . '/footer.phtml');
        print($footerEnd);
    }
}