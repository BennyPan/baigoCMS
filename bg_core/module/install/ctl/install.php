<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

if (file_exists(BG_PATH_CONFIG . "is_install.php")) {
	include_once(BG_PATH_CONFIG . "is_install.php");
	if (defined("BG_INSTALL_PUB") && PRD_CMS_PUB > BG_INSTALL_PUB) {
		header("Location: " . BG_URL_INSTALL . "ctl.php?mod=upgrade");
	} else {
		header("Location: " . BG_URL_INSTALL . "ctl.php?mod=alert&act_get=display&alert=x030403");
	}
	exit;
}

include_once(BG_PATH_INC . "common_global.inc.php"); //载入通用
include_once(BG_PATH_CLASS . "mysql.class.php"); //载入数据库类
include_once(BG_PATH_CLASS . "base.class.php"); //载入基类
include_once(BG_PATH_CONTROL_INSTALL . "ctl/install.class.php"); //载入栏目控制器

$GLOBALS["obj_base"]    = new CLASS_BASE(); //初始化基类
$ctl_install            = new CONTROL_INSTALL(); //初始化商家

switch ($GLOBALS["act_get"]) {
	case "auth":
		$arr_installRow = $ctl_install->ctl_auth();
		if ($arr_installRow["str_alert"] != "y030404") {
			header("Location: " . BG_URL_INSTALL . "ctl.php?mod=alert&act_get=display&alert=" . $arr_installRow["str_alert"]);
			exit;
		}
	break;

	case "admin":
		$arr_installRow = $ctl_install->ctl_admin();
		if ($arr_installRow["str_alert"] != "y030404") {
			header("Location: " . BG_URL_INSTALL . "ctl.php?mod=alert&act_get=display&alert=" . $arr_installRow["str_alert"]);
			exit;
		}
	break;

	case "ssoAuto":
		$arr_installRow = $ctl_install->ctl_ssoAuto();
		if ($arr_installRow["str_alert"] != "y030404") {
			header("Location: " . BG_URL_INSTALL . "ctl.php?mod=alert&act_get=display&alert=" . $arr_installRow["str_alert"]);
			exit;
		}
	break;

	case "ssoAdmin":
		$arr_installRow = $ctl_install->ctl_ssoAdmin();
		if ($arr_installRow["str_alert"] != "y030404") {
			header("Location: " . BG_URL_INSTALL . "ctl.php?mod=alert&act_get=display&alert=" . $arr_installRow["str_alert"]);
			exit;
		}
	break;

	case "sso":
		$arr_installRow = $ctl_install->ctl_sso();
		if ($arr_installRow["str_alert"] != "y030404") {
			header("Location: " . BG_URL_INSTALL . "ctl.php?mod=alert&act_get=display&alert=" . $arr_installRow["str_alert"]);
			exit;
		}
	break;

	case "upload":
		$arr_installRow = $ctl_install->ctl_upload();
		if ($arr_installRow["str_alert"] != "y030404") {
			header("Location: " . BG_URL_INSTALL . "ctl.php?mod=alert&act_get=display&alert=" . $arr_installRow["str_alert"]);
			exit;
		}
	break;

	case "visit":
		$arr_installRow = $ctl_install->ctl_visit();
		if ($arr_installRow["str_alert"] != "y030404") {
			header("Location: " . BG_URL_INSTALL . "ctl.php?mod=alert&act_get=display&alert=" . $arr_installRow["str_alert"]);
			exit;
		}
	break;

	case "base":
		$arr_installRow = $ctl_install->ctl_base();
		if ($arr_installRow["str_alert"] != "y030404") {
			header("Location: " . BG_URL_INSTALL . "ctl.php?mod=alert&act_get=display&alert=" . $arr_installRow["str_alert"]);
			exit;
		}
	break;

	case "dbtable":
		$arr_installRow = $ctl_install->ctl_dbtable();
		if ($arr_installRow["str_alert"] != "y030404") {
			header("Location: " . BG_URL_INSTALL . "ctl.php?mod=alert&act_get=display&alert=" . $arr_installRow["str_alert"]);
			exit;
		}
	break;

	case "over":
		$arr_installRow = $ctl_install->ctl_over();
		if ($arr_installRow["str_alert"] != "y030404") {
			header("Location: " . BG_URL_INSTALL . "ctl.php?mod=alert&act_get=display&alert=" . $arr_installRow["str_alert"]);
			exit;
		}
	break;

	default:
		$arr_installRow = $ctl_install->ctl_dbconfig();
		if ($arr_installRow["str_alert"] != "y030403") {
			header("Location: " . BG_URL_INSTALL . "ctl.php?mod=alert&act_get=display&alert=" . $arr_installRow["str_alert"]);
			exit;
		}
	break;
}
