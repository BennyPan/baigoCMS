<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_CLASS . "tpl_help.class.php"); //载入模板类

/*-------------文章类-------------*/
class CONTROL_TPL {

	private $obj_tpl;

	function __construct() { //构造函数
		$this->obj_base       = $GLOBALS["obj_base"];
		$this->config         = $this->obj_base->config;
		$this->obj_tpl        = new CLASS_TPL(BG_PATH_SYSTPL_HELP . $this->config["ui"]); //初始化视图对象
		$this->tplData = array(
			"helpConfig" => include_once(BG_PATH_LANG . $this->config["lang"] . "/help/config.php"),
			"config"     => include_once(BG_PATH_LANG . $this->config["lang"] . "/help/tpl/config.php"),
			"active"     => "doc",
			"mod"        => "tpl",
		);
	}

	function ctl_show($act = "outline") {
		if (!$act) {
			$act = "outline";
		}
		$this->tplData["act"]     = $act;
		$this->tplData["content"] = $this->str_process($act);

		$this->obj_tpl->tplDisplay("help.tpl", $this->tplData);
	}

	private function str_process($str_load) {
		$_str_content = include_once(BG_PATH_LANG . $this->config["lang"] . "/help/tpl/" . $str_load . ".php");
		$_str_content = str_replace("{images}", BG_URL_STATIC_HELP . $this->config["ui"] . "/tpl/", $_str_content);
		$_str_content = str_replace("{BG_URL_HELP}", BG_URL_HELP, $_str_content);
		return $_str_content;
	}
}
