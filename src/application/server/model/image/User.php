<?php
class M_Image_User extends M_Image_Base {

    public function __construct($skinID) {
        $this->setDir(C_Main::getDirSkin());
        $this->setName("Skin_" . $skinID);
    }
}