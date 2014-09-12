<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_INC . "common_admin.inc.php"); //验证是否已登录
include_once(BG_PATH_CONTROL_ADMIN . "ajax/opt.class.php"); //载入栏目控制器

$ajax_opt = new AJAX_OPT(); //初始化设置对象

switch ($act_post) {
	case "upload":
		$ajax_opt->ajax_upload();
	break;

	case "sso":
		$ajax_opt->ajax_sso();
	break;

	case "visit":
		$ajax_opt->ajax_visit();
	break;

	case "base":
		$ajax_opt->ajax_base();
	break;

	case "db":
		$ajax_opt->ajax_db();
	break;
}
?>