{$cfg = [
    sub_title  => $lang.page.upgradeOver,
    mod_help   => "upgrade",
    act_help   => "over"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}install/default/include/upgrade_head.tpl" cfg=$cfg}

    <form name="upgrade_form_over" id="upgrade_form_over">
        <input type="hidden" name="{$common.tokenRow.name_session}" value="{$common.tokenRow.token}">
        <input type="hidden" name="act_post" value="over">

        <div class="alert alert-success">
            <h4>
                <span class="glyphicon glyphicon-ok-circle"></span>
                {$lang.label.upgradeOver}
            </h4>
        </div>

        <div class="form-group">
            <div class="btn-group">
                <button type="button" id="go_next" class="btn btn-primary btn-lg">{$lang.btn.over}</button>
                {include "{$smarty.const.BG_PATH_TPLSYS}install/default/include/upgrade_drop.tpl" cfg=$cfg}
            </div>
        </div>
    </form>


{include "{$smarty.const.BG_PATH_TPLSYS}install/default/include/install_foot.tpl" cfg=$cfg}

    <script type="text/javascript">
    var opts_submit_form = {
        ajax_url: "{$smarty.const.BG_URL_INSTALL}ajax.php?mod=upgrade",
        text_submitting: "{$lang.label.submitting}",
        btn_text: "{$lang.btn.login}",
        btn_close: "{$lang.btn.close}",
        btn_url: "{$smarty.const.BG_URL_ADMIN}ctl.php"
    };

    $(document).ready(function(){
        var obj_submit_form = $("#upgrade_form_over").baigoSubmit(opts_submit_form);
        $("#go_next").click(function(){
            obj_submit_form.formSubmit();
        });
    });
    </script>

{include "{$smarty.const.BG_PATH_TPLSYS}install/default/include/html_foot.tpl" cfg=$cfg}