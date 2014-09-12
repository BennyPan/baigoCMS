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
	include_once(BG_PATH_CONFIG . "is_install.php"); //载入栏目控制器
	if (defined("BG_INSTALL_PUB") && PRD_SSO_PUB <= BG_INSTALL_PUB) {
		header("Location: " . BG_URL_INSTALL . "ctl.php?mod=alert&act_get=display&alert=x030403");
		exit;
	}
}

include_once(BG_PATH_INC . "common_global.inc.php"); //载入通用
include_once(BG_PATH_CLASS . "mysql.class.php"); //载入数据库类
include_once(BG_PATH_CLASS . "base.class.php"); //载入基类

include_once(BG_PATH_CONTROL_INSTALL . "ctl/upgrade.class.php"); //载入栏目控制器

$GLOBALS["obj_base"]    = new CLASS_BASE(); //初始化基类
$ctl_upgrade            = new CONTROL_UPGRADE(); //初始化商家

switch ($act_get) {
	case "reg":
		$arr_upgradeRow = $ctl_upgrade->ctl_reg();
		if ($arr_upgradeRow["str_alert"] != "y030404") {
			header("Location: " . BG_URL_INSTALL . "ctl.php?mod=alert&act_get=display&alert=" . $arr_upgradeRow["str_alert"]);
			exit;
		}
	break;

	case "base":
		$arr_upgradeRow = $ctl_upgrade->ctl_base();
		if ($arr_upgradeRow["str_alert"] != "y030404") {
			header("Location: " . BG_URL_INSTALL . "ctl.php?mod=alert&act_get=display&alert=" . $arr_upgradeRow["str_alert"]);
			exit;
		}
	break;

	case "over":
		$arr_upgradeRow = $ctl_upgrade->ctl_over();
		if ($arr_upgradeRow["str_alert"] != "y030404") {
			header("Location: " . BG_URL_INSTALL . "ctl.php?mod=alert&act_get=display&alert=" . $arr_upgradeRow["str_alert"]);
			exit;
		}
	break;

	default:
		$arr_upgradeRow = $ctl_upgrade->ctl_dbtable();
		if ($arr_upgradeRow["str_alert"] != "y030404") {
			header("Location: " . BG_URL_INSTALL . "ctl.php?mod=alert&act_get=display&alert=" . $arr_upgradeRow["str_alert"]);
			exit;
		}
	break;
}
?>