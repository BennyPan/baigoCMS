<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_CLASS . "ajax.class.php"); //载入 AJAX 基类
include_once(BG_PATH_MODEL . "log.class.php"); //载入管理帐号模型

/*-------------管理员控制器-------------*/
class AJAX_PROFILE {

	private $adminLogged;
	private $obj_ajax;
	private $log;
	private $mdl_admin;
	private $mdl_log;

	function __construct() { //构造函数
		$this->adminLogged    = $GLOBALS["adminLogged"]; //已登录商家信息
		$this->obj_ajax       = new CLASS_AJAX(); //初始化 AJAX 基对象
		$this->log            = $this->obj_ajax->log; //初始化 AJAX 基对象
		$this->mdl_admin      = new MODEL_ADMIN(); //设置管理组模型
		$this->mdl_log        = new MODEL_LOG(); //设置管理员模型

		if (file_exists(BG_PATH_CONFIG . "is_install.php")) { //验证是否已经安装
			include_once(BG_PATH_CONFIG . "is_install.php");
			if (!defined("BG_INSTALL_PUB") || PRD_SSO_PUB > BG_INSTALL_PUB) {
				$this->obj_ajax->halt_alert("x030411");
			}
		} else {
			$this->obj_ajax->halt_alert("x030410");
		}

		if ($this->adminLogged["str_alert"] != "y020102") { //未登录，抛出错误信息
			$this->obj_ajax->halt_alert($this->adminLogged["str_alert"]);
		}
	}


	/**
	 * ajax_my function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_info() {
		if ($this->adminLogged["admin_allow"]["info"] == 1) {
			$this->obj_ajax->halt_alert("x020108");
		}

		$_arr_adminProfile = $this->mdl_admin->input_profile();
		if ($_arr_adminProfile["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminProfile["str_alert"]);
		}

		$_arr_adminRow = $this->mdl_admin->mdl_read($this->adminLogged["admin_id"]);
		if ($_arr_adminRow["str_alert"] != "y020102") {
			return $_arr_adminRow;
			exit;
		}

		$_arr_adminRow = $this->mdl_admin->mdl_profile($this->adminLogged["admin_id"]);

		$this->obj_ajax->halt_alert($_arr_adminRow["str_alert"]);
	}


	function ajax_pass() {
		if ($this->adminLogged["admin_allow"]["pass"] == 1) {
			$this->obj_ajax->halt_alert("x020109");
		}

		$_arr_adminPass = $this->mdl_admin->input_pass();
		if ($_arr_adminPass["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminPass["str_alert"]);
		}

		$_arr_adminRow = $this->mdl_admin->mdl_read($this->adminLogged["admin_id"]);
		if ($_arr_adminRow["str_alert"] != "y020102") {
			return $_arr_adminRow;
			exit;
		}

		if (fn_baigoEncrypt($_arr_adminPass["admin_pass"], $_arr_adminRow["admin_rand"]) != $_arr_adminRow["admin_pass"]) {
			$this->obj_ajax->halt_alert("x020207");
		}

		$_arr_adminRow = $this->mdl_admin->mdl_pass($this->adminLogged["admin_id"]);

		$this->obj_ajax->halt_alert($_arr_adminRow["str_alert"]);
	}

}
