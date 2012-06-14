<?php

abstract class M_HTML_Form_Base extends M_HTML_Base {

    protected $formName;
    protected $formID;
    protected $formAction;
    protected $formMethod;
    protected $formHeader;

    public function __construct($formHeader, $formName, $formID, $formAction, $formMethod = "post") {
        $this->formName = $formName;
        $this->formID = $formID;
        $this->formAction = $formAction;
        $this->formMethod = $formMethod;
        $this->formHeader = $formHeader;
    }

    public function render() {
        ?>
    <form class="form-horizontal" name="<?=$this->formName;?>" id="<?=$this->formID;?>" action="<?=$this->formAction;?>" method="<?=$this->formMethod?>">
        <fieldset>
            <legend><?=$this->formHeader;?></legend>
    <?
            $this->htmlCode();
        ?>
        </fieldset>
    </form>
    <?
        $this->jsCode();
    }

}