<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_FUNC . "init.func.php"); //验证是否已登录
switch ($GLOBALS["act_post"]) {
    case "dbconfig":
        $arr_set = array(
            "base"      => true,
            "ssin"      => true,
            "header"    => "Content-type: application/json; charset=utf-8",
            "ssin_file" => true,
        );
    break;

    default:
        $arr_set = array(
            "base"      => true,
            "ssin"      => true,
            "header"    => "Content-type: application/json; charset=utf-8",
            "db"        => true,
            "type"      => "ajax",
        );
    break;
}
fn_init($arr_set);

include_once(BG_PATH_CLASS . "mysqli.class.php"); //载入数据库类
include_once(BG_PATH_CONTROL . "install/ajax/install.class.php"); //载入栏目控制器

$ajax_install = new AJAX_INSTALL(); //初始化商家

switch ($GLOBALS["act_post"]) {
    case "dbconfig":
        $ajax_install->ajax_dbconfig();
    break;

    case "auth":
        $ajax_install->ajax_auth();
    break;

    case "admin":
        $ajax_install->ajax_admin();
    break;

    case "ssoAuto":
        $ajax_install->ajax_ssoAuto();
    break;

    case "ssoAdmin":
        $ajax_install->ajax_ssoAdmin();
    break;

    case "over":
        $ajax_install->ajax_over();
    break;

    case "sso":
    case "upload":
    case "visit":
    case "base":
        $ajax_install->ajax_submit();
    break;

    default:
        switch ($GLOBALS["act_get"]) {
            case "chkname":
                $ajax_install->ajax_chkname();
            break;

            case "chkauth":
                $ajax_install->ajax_chkauth();
            break;
        }
    break;
}
