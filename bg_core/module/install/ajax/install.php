<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

if (isset($_GET["ssid"])) {
	session_id($_GET["ssid"]); //将当前的SessionId设置成客户端传递回来的SessionId
}

session_start(); //开启session
$GLOBALS["ssid"] = session_id();

header("Content-type: application/json");
include_once(BG_PATH_INC . "common_global.inc.php"); //载入通用
include_once(BG_PATH_CLASS . "mysql.class.php"); //载入数据库类
include_once(BG_PATH_CLASS . "base.class.php"); //载入基类
include_once(BG_PATH_CONTROL_INSTALL . "ajax/install.class.php"); //载入栏目控制器

$GLOBALS["obj_base"]    = new CLASS_BASE(); //初始化基类
$ajax_install           = new AJAX_INSTALL(); //初始化商家

switch ($GLOBALS["act_post"]) {
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

	case "sso":
		$ajax_install->ajax_sso();
	break;

	case "upload":
		$ajax_install->ajax_upload();
	break;

	case "visit":
		$ajax_install->ajax_visit();
	break;

	case "base":
		$ajax_install->ajax_base();
	break;

	case "dbtable":
		$ajax_install->ajax_dbtable();
	break;

	case "dbconfig":
		$ajax_install->ajax_dbconfig();
	break;

	case "over":
		$ajax_install->ajax_over();
	break;

	default:
		switch ($GLOBALS["act_get"]) {
			case "chkauth":
				$ajax_install->ajax_chkauth();
			break;
		}
	break;
}
