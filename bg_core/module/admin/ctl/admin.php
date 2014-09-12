<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_INC . "common_admin.inc.php"); //载入全局通用
include_once(BG_PATH_INC . "is_admin.inc.php"); //载入后台通用
include_once(BG_PATH_CONTROL_ADMIN . "ctl/admin.class.php"); //载入用户类

$ctl_admin = new CONTROL_ADMIN();

switch ($act_get) {
	case "toGroup":
		$arr_adminRow = $ctl_admin->ctl_toGroup();
		if ($arr_adminRow["str_alert"] != "y020302") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=display&alert=" . $arr_adminRow["str_alert"] . $_url_attach);
			exit;
		}
	break;

	case "form":
		$arr_adminRow = $ctl_admin->ctl_form();
		if ($arr_adminRow["str_alert"] != "y020302") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=display&alert=" . $arr_adminRow["str_alert"]);
			exit;
		}
	break;

	case "show":
		$arr_adminRow = $ctl_admin->ctl_show();
		if ($arr_adminRow["str_alert"] != "y020302") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=display&alert=" . $arr_adminRow["str_alert"]);
			exit;
		}
	break;

	case "auth":
		$arr_adminRow = $ctl_admin->ctl_auth();
		if ($arr_adminRow["str_alert"] != "y020302") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=display&alert=" . $arr_adminRow["str_alert"]);
			exit;
		}
	break;

	default:
		$arr_adminRow = $ctl_admin->ctl_list();
		if ($arr_adminRow["str_alert"] != "y020301") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=display&alert=" . $arr_adminRow["str_alert"]);
			exit;
		}
	break;
}
?>