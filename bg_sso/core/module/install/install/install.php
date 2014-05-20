<?php
/*-----------------------------------------------------------------

！！！！警告！！！！
以下为系统文件，请勿修改

-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_INC . "common_global.inc.php"); //载入通用
include_once(BG_PATH_CLASS . "mysql.class.php"); //载入数据库类
include_once(BG_PATH_CLASS . "base.class.php"); //载入基类

include_once(BG_PATH_CONTROL_INSTALL . "install/install.class.php"); //载入栏目控制器

$GLOBALS["obj_base"]    = new CLASS_BASE(); //初始化基类
$ctl_install            = new CONTROL_INSTALL(); //初始化商家

switch ($act_get) {
	case "admin":
		$arr_installRow = $ctl_install->ctl_admin();
		if ($arr_installRow["str_alert"] != "y030404") {
			header("Location: " . BG_URL_INSTALL . "install.php?mod=alert&act_get=display&alert=" . $arr_installRow["str_alert"]);
			exit;
		}
	break;

	case "reg":
		$arr_installRow = $ctl_install->ctl_reg();
		if ($arr_installRow["str_alert"] != "y030404") {
			header("Location: " . BG_URL_INSTALL . "install.php?mod=alert&act_get=display&alert=" . $arr_installRow["str_alert"]);
			exit;
		}
	break;

	case "base":
		$arr_installRow = $ctl_install->ctl_base();
		if ($arr_installRow["str_alert"] != "y030404") {
			header("Location: " . BG_URL_INSTALL . "install.php?mod=alert&act_get=display&alert=" . $arr_installRow["str_alert"]);
			exit;
		}
	break;

	case "dbtable":
		$arr_installRow = $ctl_install->ctl_dbtable();
		if ($arr_installRow["str_alert"] != "y030404") {
			header("Location: " . BG_URL_INSTALL . "install.php?mod=alert&act_get=display&alert=" . $arr_installRow["str_alert"]);
			exit;
		}
	break;

	default:
		$arr_installRow = $ctl_install->ctl_dbconfig();
		if ($arr_installRow["str_alert"] != "y030403") {
			header("Location: " . BG_URL_INSTALL . "install.php?mod=alert&act_get=display&alert=" . $arr_installRow["str_alert"]);
			exit;
		}
	break;
}
?>