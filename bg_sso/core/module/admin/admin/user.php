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
include_once(BG_PATH_INC . "is_admin.inc.php"); //验证是否已登录

include_once(BG_PATH_CONTROL_ADMIN . "admin/user.class.php"); //载入商家控制器
$ctl_user = new CONTROL_USER(); //初始化商家

switch ($act_get) {
	default:
		$arr_userRow = $ctl_user->ctl_list();
		if ($arr_userRow["str_alert"] != "y010302") {
			header("Location: " . BG_URL_ADMIN . "admin.php?mod=alert&act_get=display&alert=" . $arr_userRow["str_alert"]);
			exit;
		}
	break;
}
?>