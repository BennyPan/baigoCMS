<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_FUNC . "init.func.php"); //验证是否已登录
$arr_set = array(
    "base"          => true,
    "ssin"          => true,
    "header"        => "Content-type: application/json; charset=utf-8",
    "db"            => true,
    "type"          => "ajax",
    "ssin_begin"    => true,
);
fn_init($arr_set);

include_once(BG_PATH_CONTROL . "admin/ajax/opt.class.php"); //载入栏目控制器

$ajax_opt = new AJAX_OPT(); //初始化设置对象

switch ($GLOBALS["act_post"]) {
    case "chkver":
        $ajax_opt->ajax_chkver(); //数据库
    break;

    case "dbconfig":
        $ajax_opt->ajax_dbconfig();
    break;

    default:
        $ajax_opt->ajax_submit();
    break;
}
