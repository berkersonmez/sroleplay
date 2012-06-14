<?php
abstract class M_Image_Base extends M_Model {
    protected $name;
    protected $dir;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDir()
    {
        return $this->dir;
    }

    public function setDir($dir)
    {
        $this->dir = $dir;
    }

    public function construct() {
        return $this->dir . "/" . $this->name . ".png";
    }

    public function constructThumbnail() {
        return $this->dir . "/thumb_" . $this->name . ".png";
    }

    public function noImage() {
        return C_Main::getDirStyleImg() . "/no-image.jpg";
    }

    public function get() {
        if (file_exists($this->construct())) {
            return $this->construct();
        }
        return $this->noImage();
    }

    public function getThumbnail() {
        if (file_exists($this->constructThumbnail())) {
            return $this->constructThumbnail();
        }
        return $this->noImage();
    }

    public function exists() {
        return file_exists($this->construct());
    }

    public function existsThumbnail() {
        return file_exists($this->constructThumbnail());
    }

    public function printSkin($width, $height) {
        ?>
    <img src="<?=$this->get();?>" class="thmb" style="width: <?=$width;?>; height: <?=$height;?>;"/>
    <?
    }
}