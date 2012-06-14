<?php
class M_HTML_Form_Register extends M_HTML_Form_Base {

    public function htmlCode()
    {
        ?>
    <div class="alert alert-info"><?=C_T::_("Tüm alanları doldurmak zorunludur!")?></div>
    <div id="ajax-result"></div>
    <div class="control-group">
        <label class="control-label" for="reg_email"><?=C_T::_("E-mail")?></label>
        <div class="controls">
            <input type="text" class="input-xlarge" id="reg_email" name="reg_email"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="reg_pass"><?=C_T::_("Şifre")?></label>
        <div class="controls">
            <input type="password" class="input-xlarge" id="reg_pass" name="reg_pass"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="reg_passagain"><?=C_T::_("Şifre Tekrar")?></label>
        <div class="controls">
            <input type="password" class="input-xlarge" id="reg_passagain" name="reg_passagain"/>
        </div>
    </div>
        <hr/>
    <div class="control-group">
        <label class="control-label" for="reg_name"><?=C_T::_("Karakter Adı")?></label>
        <div class="controls">
            <input type="text" class="input-xlarge" id="reg_name" name="reg_name"/>
            <p class="help-block">Türkçe karakter (ğ,ü,ş,ç,ö), noktalama işareti vb. girmeyiniz.</p>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="reg_surname"><?=C_T::_("Karakter Soyadı")?></label>
        <div class="controls">
            <input type="text" class="input-xlarge" id="reg_surname" name="reg_surname"/>
            <p class="help-block">Türkçe karakter (ğ,ü,ş,ç,ö), noktalama işareti vb. girmeyiniz.</p>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="reg_gender"><?=C_T::_("Karakter Cinsiyeti")?></label>
        <div class="controls">
            <select class="input-xlarge" id="reg_gender" name="reg_gender">
                <option value="BI"><?=C_T::_("Belirsiz / Biseksüel")?></option>
                <option value="MALE"><?=C_T::_("Erkek")?></option>
                <option value="FEMALE"><?=C_T::_("Kadın")?></option>
            </select>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="reg_age"><?=C_T::_("Karakter Yaşı")?></label>
        <div class="controls">
            <select class="input-xlarge" id="reg_age" name="reg_age">
                <? for ($i = 1 ; $i < 65 ; $i++) :?>
                    <option value="<?=$i;?>"><?=$i;?></option>
                <? endfor; ?>
            </select>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="reg_bio"><?=C_T::_("Karakter Biyografisi")?></label>
        <div class="controls">
            <textarea class="input-xlarge" id="reg_bio" rows="3" name="reg_bio"></textarea>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="reg_public"></label>
        <div class="controls">
            <label class="checkbox">
                <input type="checkbox" id="reg_public" name="reg_public"/>
                <?=C_T::_("Karakterimi herkes görebilsin.")?>
            </label>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="reg_agreement"></label>
        <div class="controls">
            <label class="checkbox">
                <input type="checkbox" id="reg_agreement" name="reg_agreement"/>
                <strong><?=C_T::_("Çok düzgün bilgiler girdiğimi kabul ediyorum. Oyunda hile yapmayacağım, küfür etmeyeceğim.")?></strong>
            </label>
        </div>
    </div>
    <input type="hidden" name="ark" value="<?= C_Session::createAjaxRequestKey(); ?>"/>
    <div class="form-actions">
        <button type="submit" class="btn btn-primary" id="submit_reg">Kaydol!</button>
    </div>
    <?
    }

    public function cssCode()
    {
    }

    public function jsCode()
    {
        ?>
    <script type="text/javascript">
        $(function () {
            <? C_Ajax::jsFormResponseParser(); ?>
            $("#form_reg").submit(function (event) {
                event.preventDefault();
                $("#submit_reg").attr('disabled', 'disabled').addClass("disabled");
                var $form = $(this),
                    regEmail = $form.find('input[name="reg_email"]').val(),
                    regPass = $form.find('input[name="reg_pass"]').val(),
                    regPassagain = $form.find('input[name="reg_passagain"]').val(),
                    regName = $form.find('input[name="reg_name"]').val(),
                    regSurname = $form.find('input[name="reg_surname"]').val(),
                    regGender = $form.find('select[name="reg_gender"]').val(),
                    regAge = $form.find('select[name="reg_age"]').val(),
                    regBio = $form.find('textarea[name="reg_bio"]').val(),
                    regPublic = $form.find('input[name="reg_public"]').is(':checked') ? 1 : 0,
                    regAgreement = $form.find('input[name="reg_agreement"]').is(':checked') ? 1 : 0,
                    ARK = $form.find('input[name="ark"]').val(),
                    url = $form.attr('action');
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        reg_email:regEmail,
                        reg_pass:regPass,
                        reg_passagain:regPassagain,
                        reg_name:regName,
                        reg_surname:regSurname,
                        reg_gender:regGender,
                        reg_age:regAge,
                        reg_bio:regBio,
                        reg_public:regPublic,
                        reg_agreement:regAgreement,
                        ark:ARK},
                    dataType: "json",
                    success: function(data){
                        $("#submit_reg").removeAttr("disabled").removeClass("disabled");
                        $("#ajax-result").empty().append(ajaxResponse(data));
                        if (ajaxSuccess) {
                            window.location = 'index.php?register=successful';
                        }
                    },
                    error: function(x, y, z) {
                        $("#ajax-result").empty().append(x+y+z);
                    }
                });
            });
        });
    </script>
    <?
    }
}