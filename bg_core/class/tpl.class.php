<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_SMARTY . "smarty.class.php"); //载入 Smarty 类

/*-------------模板类-------------*/
class CLASS_TPL {

	public $common; //通用
	public $obj_base;
	private $obj_smarty; //Smarty
	public $config; //配置
	public $lang; //语言 通用
	public $status; //语言 状态
	public $type; //语言 类型
	public $alert; //语言 提示代码
	public $adminMod; //语言 后台
	public $opt; //语言 后台

	function __construct($str_pathTpl) { //构造函数
		$this->obj_base                   = $GLOBALS["obj_base"];
		$this->config                     = $this->obj_base->config;

		$this->obj_smarty                 = new Smarty(); //初始化 Smarty 对象
		$this->obj_smarty->template_dir   = $str_pathTpl;
		$this->obj_smarty->compile_dir    = BG_PATH_TPL_COMPILE;
		$this->obj_smarty->debugging      = BG_SWITCH_SMARTY_DEBUG; //调试模式

		$this->lang       = include_once(BG_PATH_LANG . $this->config["lang"] . "/common.php"); //载入语言文件
		$this->status     = include_once(BG_PATH_LANG . $this->config["lang"] . "/status.php"); //载入状态文件
		$this->type       = include_once(BG_PATH_LANG . $this->config["lang"] . "/type.php"); //载入类型文件
		$this->alert      = include_once(BG_PATH_LANG . $this->config["lang"] . "/alert.php"); //载入提示代码
		$this->install    = include_once(BG_PATH_LANG . $this->config["lang"] . "/install.php"); //载入安装代码
		$this->opt        = include_once(BG_PATH_LANG . $this->config["lang"] . "/opt.php"); //载入设置配置
		$this->adminMod   = include_once(BG_PATH_LANG . $this->config["lang"] . "/adminMod.php"); //载入管理权限配置
	}


	/** 显示页面
	 * tplDisplay function.
	 *
	 * @access public
	 * @param mixed $str_tpl 模版名
	 * @param string $arr_tplData (default: "") 模版数据
	 * @return void
	 */
	function tplDisplay($str_tpl, $arr_tplData = "") {
		$this->common["token_session"]    = fn_token(); //生成口令
		$this->common["token_cookie"]     = fn_cookie("token_cookie_" . BG_SITE_SSIN); //输出cookie口令（特殊用途，用于上传）
		$this->common["ssid"]             = session_id(); //会话ID（特殊用途，用于上传）

		if (!BG_MODULE_GEN) {
			unset($this->adminMod["gen"]);
		}

		$this->obj_smarty->assign("common", $this->common);
		$this->obj_smarty->assign("config", $this->config);
		$this->obj_smarty->assign("lang", $this->lang);
		$this->obj_smarty->assign("status", $this->status);
		$this->obj_smarty->assign("type", $this->type);
		$this->obj_smarty->assign("alert", $this->alert);
		$this->obj_smarty->assign("install", $this->install);
		$this->obj_smarty->assign("opt", $this->opt);
		$this->obj_smarty->assign("adminMod", $this->adminMod);
		$this->obj_smarty->assign("tplData", $arr_tplData);

		$this->obj_smarty->display($str_tpl); //显示
	}
}
?>