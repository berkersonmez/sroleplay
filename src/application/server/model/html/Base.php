<?php

abstract class M_HTML_Base extends M_Model {

    public abstract function htmlCode();
    public abstract function cssCode();
    public abstract function jsCode();
    public function render() {
        $this->htmlCode();
        $this->jsCode();
    }

}