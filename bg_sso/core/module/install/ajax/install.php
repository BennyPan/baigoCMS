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
include_once(BG_PATH_CONTROL_INSTALL . "ajax/install.class.php"); //载入栏目控制器

$GLOBALS["obj_base"]    = new CLASS_BASE(); //初始化基类
$ajax_install           = new AJAX_INSTALL(); //初始化商家

switch ($act_post) {
	case "admin":
		$ajax_install->ajax_admin();
	break;

	case "reg":
		$ajax_install->ajax_reg();
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
}
?>