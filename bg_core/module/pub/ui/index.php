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
require(BG_PATH_FUNC . "init.func.php");
$arr_set = array(
    "base"      => true,
    "db"        => true,
    "pub"       => true,
);
fn_init($arr_set);

$ctrl_index = new CONTROL_PUB_UI_INDEX();

switch ($GLOBALS["act"]) {
    default:
        $ctrl_index->ctrl_index();
    break;
}
