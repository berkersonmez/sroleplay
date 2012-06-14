<?php
class M_HTML_Form_Login extends M_HTML_Form_Base {

    public function htmlCode()
    {
        ?>
    <div class="alert alert-info"><a href="<?=C_Link::create("registry", "index");?>"><?=C_T::_("Kayıtlı değil misin? Hemen kaydol!")?></a></div>
    <div id="ajax-result"></div>
    <div class="control-group">
        <label class="control-label" for="login_username"><?=C_T::_("E-Mail")?></label>
        <div class="controls">
            <input type="text" class="input-xlarge" id="login_username" name="login_username"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="login_pass"><?=C_T::_("Şifre")?></label>
        <div class="controls">
            <input type="password" class="input-xlarge" id="login_pass" name="login_pass"/>
        </div>
    </div>
    <input type="hidden" name="ark" value="<?= C_Session::createAjaxRequestKey(); ?>"/>
    <div class="form-actions">
        <button type="submit" class="btn btn-primary" id="submit_login"><?=C_T::_("Giriş Yap!")?></button>
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
            $("#form_login").submit(function (event) {
                event.preventDefault();
                $("#submit_login").attr('disabled', 'disabled').addClass("disabled");
                var $form = $(this),
                    loginEmailOrUser = $form.find('input[name="login_username"]').val(),
                    loginPassword = $form.find('input[name="login_pass"]').val(),
                    loginRemember = 0,
                    ARK = $form.find('input[name="ark"]').val(),
                    url = $form.attr('action');
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        login_username:loginEmailOrUser,
                        login_pass:loginPassword,
                        login_remember:loginRemember,
                        ark:ARK},
                    dataType: "json",
                    success: function(data){
                        $("#submit_login").removeAttr("disabled").removeClass("disabled");
                        $("#ajax-result").empty().append(ajaxResponse(data));
                        if (ajaxSuccess) {
                            window.location = 'index.php';
                        }
                    }
                });
            });
        });
    </script>
    <?
    }
}