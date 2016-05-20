<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_FUNC . "http.func.php"); //载入 http
include_once(BG_PATH_CLASS . "sso.class.php"); //载入 SSO
include_once(BG_PATH_CLASS . "tpl.class.php"); //载入模板类

/*-------------用户类-------------*/
class CONTROL_LOGON {

    private $obj_base;
    private $config;
    private $obj_sso;
    private $obj_tpl;
    private $mdl_admin;


    function __construct() { //构造函数
        $this->obj_base     = $GLOBALS["obj_base"];
        $this->config       = $this->obj_base->config;
        $this->obj_sso      = new CLASS_SSO(); //SSO
        $this->mdl_admin    = new MODEL_ADMIN(); //设置管理员对象
        $_arr_cfg["admin"]  = true;
        $this->obj_tpl      = new CLASS_TPL(BG_PATH_TPLSYS . "admin/" . $this->config["ui"], $_arr_cfg); //初始化视图对象
    }


    /**
     * ctl_login function.
     *
     * @access public
     * @return void
     */
    function ctl_login() {
        $_arr_adminLogin = $this->mdl_admin->input_login();
        if ($_arr_adminLogin["alert"] != "ok") {
            return $_arr_adminLogin;
        }

        $_arr_ssoLogin = $this->obj_sso->sso_login($_arr_adminLogin["admin_name"], $_arr_adminLogin["admin_pass"]); //sso验证
        if ($_arr_ssoLogin["alert"] != "y010401") {
            $_arr_ssoLogin["forward"] = $_arr_adminLogin["forward"];
            return $_arr_ssoLogin;
        }

        $_arr_ssin = fn_ssin_login($_arr_ssoLogin["user_id"]);
        if ($_arr_ssin["alert"] != "ok") {
            $_arr_ssin["forward"] = $_arr_adminLogin["forward"];
            return $_arr_ssin;
        }

        $_arr_sync = array();

        if(defined("BG_SSO_SYNC") && BG_SSO_SYNC == "on") {
            $_arr_sync = $this->obj_sso->sso_sync_login($_arr_ssoLogin["user_id"]);
        }

        $_arr_tplData = array(
            "admin_id"   => $_arr_ssoLogin["user_id"],
            "forward"    => base64_decode($_arr_adminLogin["forward"]),
            "sync"       => $_arr_sync,
        );

        $this->obj_tpl->tplDisplay("login.tpl", $_arr_tplData);

        return array(
            "alert"      => "y020401",
        );
    }


    /**
     * ctl_logon function.
     *
     * @access public
     * @return void
     */
    function ctl_logon() {
        $_str_forward     = fn_getSafe(fn_get("forward"), "txt", "");
        $_str_alert       = fn_getSafe(fn_get("alert"), "txt", "");

        $_arr_tplData = array(
            "forward"    => $_str_forward,
            "alert"      => $_str_alert,
        );

        $this->obj_tpl->tplDisplay("logon.tpl", $_arr_tplData);
        //print_r($GLOBALS["ssid"]);
    }


    /**
     * ctl_logout function.
     *
     * @access public
     * @return void
     */
    function ctl_logout() {
        $_str_forward  = fn_getSafe(fn_get("forward"), "txt", "");
        if (!$_str_forward) {
            $_str_forward = base64_encode(BG_URL_ADMIN . "ctl.php");
        }

        fn_ssin_end();

        return array(
            "forward" => $_str_forward,
        );
    }
}
