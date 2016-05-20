<!DOCTYPE html>
<html lang="{$config.lang|truncate:2:''}">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>{$lang.page.adminLogon} - {$lang.page.admin} - {$smarty.const.BG_SITE_NAME}</title>

    <!--jQuery 库-->
    <script src="{$smarty.const.BG_URL_STATIC}js/jquery.min.js" type="text/javascript"></script>
    <link href="{$smarty.const.BG_URL_STATIC}js/bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="{$smarty.const.BG_URL_STATIC}js/baigoValidator/baigoValidator.css" type="text/css" rel="stylesheet">
    <link href="{$smarty.const.BG_URL_STATIC}admin/{$config.ui}/css/admin_logon.css" type="text/css" rel="stylesheet">

</head>

<body>

    <div class="container global">

        <h3>{$smarty.const.BG_SITE_NAME}</h3>

        <div class="panel panel-info">

            <div class="panel-heading">
                <h4>
                    {$lang.page.adminLogon}
                </h4>
            </div>

            <div class="panel-body">
                <form action="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=logon" method="post" id="login_form">
                    <input type="hidden" name="act_post" value="login">
                    <input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
                    <input type="hidden" name="forward" value="{$tplData.forward}">

                    <div class="form-group">
                        {if $tplData.alert}
                            <div class="alert alert-danger">{$alert[$tplData.alert]}</div>
                        {/if}
                    </div>

                    <div class="form-group">
                        <div id="group_admin_name">
                            <label class="control-label">{$lang.label.username}<span id="msg_admin_name">*</span></label>
                            <input type="text" name="admin_name" id="admin_name" placeholder="{$alert.x010201}" data-validate class="form-control input-lg">
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="group_admin_pass">
                            <label class="control-label">{$lang.label.password}<span id="msg_admin_pass">*</span></label>
                            <input type="password" name="admin_pass" id="admin_pass" placeholder="{$alert.x010212}" data-validate class="form-control input-lg">
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="group_seccode">
                            <label class="control-label">{$lang.label.seccode}<span id="msg_seccode">*</span></label>
                            <div class="input-group">
                                <input type="text" name="seccode" id="seccode" placeholder="{$alert.x030201}" data-validate class="form-control input-lg">
                                <span class="input-group-addon">
                                    <a href="javascript:reloadImg('seccodeImg', '{$smarty.const.BG_URL_ADMIN}ctl.php?mod=seccode&act_get=make');" title="{$lang.alt.seccode}">
                                        <img src="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=seccode&act_get=make" id="seccodeImg" alt="{$lang.alt.seccode}" height="32">
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="button" class="btn btn-primary btn-lg btn-block" id="go_login">{$lang.btn.login}</button>
                    </div>

                    <div class="form-group">

                    </div>

                </form>
            </div>

            <div class="panel-footer">
                <div class="pull-left">
                    <small>
                        {$smarty.const.PRD_CMS_POWERED}
                        {if $config.ui == "default"}
                            <a href="{$smarty.const.PRD_CMS_URL}" target="_blank">{$smarty.const.PRD_CMS_NAME}</a>
                        {else}
                            {$config.ui} CMS
                        {/if}
                        {$smarty.const.PRD_CMS_VER}
                    </small>
                </div>
                <div class="pull-right foot_logo">
                    {if $config.ui == "default"}
                        <a href="{$smarty.const.PRD_CMS_URL}" target="_blank">{$smarty.const.PRD_CMS_POWERED} {$smarty.const.PRD_CMS_NAME} {$smarty.const.PRD_CMS_VER}</a>
                    {else}
                        <a href="#">{$config.ui} CMS</a>
                    {/if}
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

    </div>

    <script type="text/javascript">
    var opts_validator_form = {
        admin_name: {
            len: { min: 1, max: 30 },
            validate: { type: "str", format: "strDigit", group: "#group_admin_name" },
            msg: { selector: "#msg_admin_name", too_short: "{$alert.x010201}", too_long: "{$alert.x010202}", format_err: "{$alert.x010203}" }
        },
        admin_pass: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "text", group: "#group_admin_pass" },
            msg: { selector: "#msg_admin_pass", too_short: "{$alert.x010212}" }
        },
        seccode: {
            len: { min: 4, max: 4 },
            validate: { type: "ajax", format: "text", group: "#group_seccode" },
            msg: { selector: "#msg_seccode", too_short: "{$alert.x030201}", too_long: "{$alert.x030201}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
            ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=seccode&act_get=chk", key: "seccode", type: "str" }
        }
    };

    function go_login() {
        var obj_validate_form = $("#login_form").baigoValidator(opts_validator_form);
        if (obj_validate_form.verify()) {
            $("#login_form").submit();
        }
    }

    $(document).ready(function(){
        $("#go_login").click(function(){
            go_login();
        });
        $("body").keydown(function(_e){
            if (_e.keyCode == 13) {
                go_login();
            }
        });
    });
    </script>

    <script src="{$smarty.const.BG_URL_STATIC}js/baigoValidator/baigoValidator.min.js" type="text/javascript"></script>
    <script src="{$smarty.const.BG_URL_STATIC}js/reloadImg.js" type="text/javascript"></script>
    <script src="{$smarty.const.BG_URL_STATIC}js/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

    <!-- {$smarty.const.PRD_CMS_POWERED} {if $config.ui == "default"}{$smarty.const.PRD_CMS_NAME}{else}{$config.ui} CMS{/if} {$smarty.const.PRD_CMS_VER} -->

</body>
</html>