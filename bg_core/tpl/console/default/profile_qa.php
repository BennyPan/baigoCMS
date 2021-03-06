<?php $cfg = array(
    "title"          => $this->lang["page"]["profile"] . " &raquo; " . $this->type["profile"]["qa"]["title"],
    "menu_active"    => "profile",
    "sub_active"     => "qa",
    "baigoValidator" => "true",
    "baigoSubmit"    => "true",
    "pathInclude"    => BG_PATH_TPLSYS . "console/default/include/",
    "str_url"        => BG_URL_CONSOLE . "index.php?mod=profile&act=pass"
);

include($cfg["pathInclude"] . "function.php");
include($cfg["pathInclude"] . "console_head.php"); ?>

    <div class="form-group">
        <ul class="nav nav-pills bg-nav-pills">
            <?php include($cfg["pathInclude"] . "profile_menu.php"); ?>
        </ul>
    </div>

    <form name="profile_form" id="profile_form" autocomplete="off">
        <input type="hidden" name="<?php echo $this->common["tokenRow"]["name_session"]; ?>" value="<?php echo $this->common["tokenRow"]["token"]; ?>">
        <input type="hidden" name="act" value="qa">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang["label"]["username"]; ?></label>
                            <input type="text" class="form-control" readonly value="<?php echo $this->tplData["ssoRow"]["user_name"]; ?>">
                        </div>

                        <div class="form-group">
                            <div id="group_admin_pass">
                                <label class="control-label"><?php echo $this->lang["label"]["password"]; ?><span id="msg_admin_pass">*</span></label>
                                <input type="password" name="admin_pass" id="admin_pass" data-validate class="form-control">
                            </div>
                        </div>

                        <?php for ($_iii = 1; $_iii <= 3; $_iii++) { ?>
                            <hr class="bg-panel-hr">
                            <div class="form-group">
                                <div id="group_admin_sec_ques_<?php echo $_iii; ?>">
                                    <label class="control-label">
                                        <?php echo $this->lang["label"]["secQues"]; ?>
                                        <?php echo $_iii; ?>
                                        <span id="msg_admin_sec_ques_<?php echo $_iii; ?>">*</span>
                                    </label>
                                    <div class="row">
                                        <div class="col-sm-7 col-xs-6">
                                            <input type="text" name="admin_sec_ques_<?php echo $_iii; ?>" id="admin_sec_ques_<?php echo $_iii; ?>" data-validate value="<?php echo $this->tplData["ssoRow"]["user_sec_ques_" . $_iii]; ?>" class="form-control">
                                        </div>
                                        <div class="col-sm-5 col-xs-6">
                                            <select class="form-control" id="admin_ques_often_<?php echo $_iii; ?>">
                                                <option value=""><?php echo $this->lang["option"]["pleaseQuesOften"]; ?></option>
                                                <?php foreach ($this->type["quesOften"] as $_key=>$_value) { ?>
                                                    <option value="<?php echo $_value; ?>"><?php echo $_value; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div id="group_admin_sec_answ_<?php echo $_iii; ?>">
                                    <label class="control-label">
                                        <?php echo $this->lang["label"]["secAnsw"]; ?>
                                        <?php echo $_iii; ?>
                                        <span id="msg_admin_sec_answ_<?php echo $_iii; ?>">*</span>
                                    </label>
                                    <div class="row">
                                        <div class="col-sm-7 col-xs-6">
                                            <input type="text" name="admin_sec_answ_<?php echo $_iii; ?>" id="admin_sec_answ_<?php echo $_iii; ?>" data-validate class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="bg-submit-box"></div>
                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang["btn"]["save"]; ?></button>
                    </div>
                </div>
            </div>

            <?php include($cfg["pathInclude"] . "profile_side.php"); ?>
        </div>

    </form>

<?php include($cfg["pathInclude"] . "console_foot.php"); ?>

    <script type="text/javascript">
    var opts_validator_form = {
        <?php for ($_iii = 1; $_iii <= 3; $_iii++) { ?>
            admin_sec_ques_<?php echo $_iii; ?>: {
                len: { min: 1, max: 0 },
                validate: { type: "str", format: "text", group: "#group_admin_sec_ques_<?php echo $_iii; ?>" },
                msg: { selector: "#msg_admin_sec_ques_<?php echo $_iii; ?>", too_short: "<?php echo $this->rcode["x010238"]; ?> <?php echo $_iii; ?>", too_long: "<?php echo $this->rcode["x010236"]; ?>" }
            },
            admin_sec_answ_<?php echo $_iii; ?>: {
                len: { min: 1, max: 0 },
                validate: { type: "str", format: "text", group: "#group_admin_sec_answ_<?php echo $_iii; ?>" },
                msg: { selector: "#msg_admin_sec_answ_<?php echo $_iii; ?>", too_short: "<?php echo $this->rcode["x010237"]; ?> <?php echo $_iii; ?>" }
            },
        <?php } ?>
        admin_pass: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "text", group: "#group_admin_pass" },
            msg: { selector: "#msg_admin_pass", too_short: "<?php echo $this->rcode["x010212"]; ?>" }
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=profile",
        msg_text: {
            submitting: "<?php echo $this->lang["label"]["submitting"]; ?>"
        }
    };

    $(document).ready(function(){
        var obj_validate_form   = $("#profile_form").baigoValidator(opts_validator_form);
        var obj_submit_form     = $("#profile_form").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });

        <?php for ($_iii = 1; $_iii <= 3; $_iii++) { ?>
            $("#admin_ques_often_<?php echo $_iii; ?>").change(function(){
                var _qo_<?php echo $_iii; ?> = $(this).val();
                $("#admin_sec_ques_<?php echo $_iii; ?>").val(_qo_<?php echo $_iii; ?>);
            });
        <?php } ?>
    });
    </script>

<?php include($cfg["pathInclude"] . "html_foot.php"); ?>