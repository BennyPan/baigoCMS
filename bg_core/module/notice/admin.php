<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_INC . "common_notice.inc.php"); //验证是否已登录
include_once(BG_PATH_CONTROL_NOTICE . "admin.class.php"); //载入文章类

$notice_admin = new NOTICE_ADMIN();

switch ($GLOBALS["act_get"]) {
	case "login":
		$notice_admin->notice_login();
	break;

	case "logout":
		$notice_admin->notice_logout();
	break;
}
