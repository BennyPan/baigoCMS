<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/
$base = $_SERVER["DOCUMENT_ROOT"] . str_replace(basename(dirname($_SERVER["PHP_SELF"])), "", dirname($_SERVER["PHP_SELF"]));
include_once($base . "bg_config/config.inc.php"); //载入配置

$arr_mod = array("article", "tag", "mark", "spec", "cate", "attach", "mime", "thumb", "call", "gen", "user", "admin", "group", "opt", "app", "alert", "profile", "logon", "seccode", "help");

if (isset($_GET["mod"])) {
	$mod = $_GET["mod"];
} else {
	$mod = $arr_mod[0];
}

if (!in_array($mod, $arr_mod)) {
	exit("Access Denied");
}

include_once(BG_PATH_MODULE_ADMIN . "ctl/" . $mod . ".php");