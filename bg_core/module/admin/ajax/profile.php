<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_INC . "common_admin_ajax.inc.php"); //验证是否已登录
include_once(BG_PATH_CONTROL_ADMIN . "ajax/profile.class.php"); //载入登录控制器

$ajax_profile = new AJAX_PROFILE();

switch ($GLOBALS["act_post"]) {
	case "pass":
		$ajax_profile->ajax_pass();
	break;

	case "info":
		$ajax_profile->ajax_info();
	break;
}
