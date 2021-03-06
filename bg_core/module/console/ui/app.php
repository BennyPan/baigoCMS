<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

require(BG_PATH_INC . "common.inc.php");
$arr_set = array(
    "base"          => true,
    "ssin"          => true,
    "db"            => true,
);
fn_chkPHP($arr_set);

require(BG_PATH_FUNC . "init.func.php");
fn_init($arr_set);

$ctrl_app = new CONTROL_CONSOLE_UI_APP(); //初始化应用

switch ($GLOBALS["act"]) {
    case "show": //显示
        $ctrl_app->ctrl_show();
    break;

    case "form": //创建、编辑表单
        $ctrl_app->ctrl_form();
    break;

    case "belong": //用户授权
        $ctrl_app->ctrl_belong();
    break;

    default: //列出
        $ctrl_app->ctrl_list();
    break;
}
