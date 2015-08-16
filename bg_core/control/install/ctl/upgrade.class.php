<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_CLASS . "dir.class.php"); //载入模板类
include_once(BG_PATH_CLASS . "tpl_admin.class.php"); //载入模板类

class CONTROL_UPGRADE {

	private $obj_tpl;

	function __construct() { //构造函数
		$this->obj_base   = $GLOBALS["obj_base"];
		$this->config     = $this->obj_base->config;
		$this->obj_tpl    = new CLASS_TPL(BG_PATH_SYSTPL_INSTALL . $this->config["ui"]);
		$this->obj_dir    = new CLASS_DIR(); //初始化目录对象
		$this->upgrade_init();
	}


	function ctl_ext() {
		$this->obj_tpl->tplDisplay("upgrade_ext.tpl", $this->tplData);

		return array(
			"alert" => "y030403",
		);
	}


	function ctl_dbconfig() {
		if ($this->errCount > 0) {
			return array(
				"alert" => "x030418",
			);
			exit;
		}

		$this->obj_tpl->tplDisplay("upgrade_dbconfig.tpl", $this->tplData);

		return array(
			"alert" => "y030403",
		);
	}


	/**
	 * upgrade_2 function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_dbtable() {
		if ($this->errCount > 0) {
			return array(
				"alert" => "x030418",
			);
			exit;
		}

		if (!$this->check_db()) {
			return array(
				"alert" => "x030419",
			);
			exit;
		}

		$this->obj_tpl->tplDisplay("upgrade_dbtable.tpl", $this->tplData);

		return array(
			"alert" => "y030404",
		);
	}


	/**
	 * upgrade_3 function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_base() {
		if ($this->errCount > 0) {
			return array(
				"alert" => "x030418",
			);
			exit;
		}

		if (!$this->check_db()) {
			return array(
				"alert" => "x030419",
			);
			exit;
		}


		$_arr_tplRows                 = $this->obj_dir->list_dir(BG_PATH_TPL_PUB);

		$_arr_tpl = array(
			"tplRows"    => $_arr_tplRows,
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("upgrade_base.tpl", $_arr_tplData);

		return array(
			"alert" => "y030404",
		);
	}


	/**
	 * upgrade_4 function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_visit() {
		if ($this->errCount > 0) {
			return array(
				"alert" => "x030418",
			);
			exit;
		}

		if (!$this->check_db()) {
			return array(
				"alert" => "x030419",
			);
			exit;
		}

		if(BG_MODULE_GEN == false) {
			unset($this->obj_tpl->opt["visit"]["BG_VISIT_TYPE"]["option"]["static"], $this->obj_tpl->opt["visit"]["BG_VISIT_FILE"]);
		}

		$this->obj_tpl->tplDisplay("upgrade_visit.tpl", $this->tplData);

		return array(
			"alert" => "y030404",
		);
	}


	/**
	 * upgrade_5 function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_upload() {
		if ($this->errCount > 0) {
			return array(
				"alert" => "x030418",
			);
			exit;
		}

		if (!$this->check_db()) {
			return array(
				"alert" => "x030419",
			);
			exit;
		}


		if(BG_MODULE_FTP == false) {
			unset($this->obj_tpl->opt["upload"]["BG_UPLOAD_URL"], $this->obj_tpl->opt["upload"]["BG_UPLOAD_FTPHOST"], $this->obj_tpl->opt["upload"]["BG_UPLOAD_FTPPORT"], $this->obj_tpl->opt["upload"]["BG_UPLOAD_FTPUSER"], $this->obj_tpl->opt["upload"]["BG_UPLOAD_FTPPASS"], $this->obj_tpl->opt["upload"]["BG_UPLOAD_FTPPATH"]);
		}

		$this->obj_tpl->tplDisplay("upgrade_upload.tpl", $this->tplData);

		return array(
			"alert" => "y030404",
		);
	}


	/**
	 * upgrade_6 function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_sso() {
		if ($this->errCount > 0) {
			return array(
				"alert" => "x030418",
			);
			exit;
		}

		if (!$this->check_db()) {
			return array(
				"alert" => "x030419",
			);
			exit;
		}


		$this->obj_tpl->tplDisplay("upgrade_sso.tpl", $this->tplData);

		return array(
			"alert" => "y030404",
		);
	}


	function ctl_over() {
		if ($this->errCount > 0) {
			return array(
				"alert" => "x030418",
			);
			exit;
		}

		if (!$this->check_db()) {
			return array(
				"alert" => "x030419",
			);
			exit;
		}

		$this->obj_tpl->tplDisplay("upgrade_over.tpl", $this->tplData);

		return array(
			"alert" => "y030404",
		);
	}


	private function check_db() {
		if (strlen(BG_DB_HOST) < 1 || strlen(BG_DB_NAME) < 1 || strlen(BG_DB_USER) < 1 || strlen(BG_DB_PASS) < 1 || strlen(BG_DB_CHARSET) < 1) {
			return false;
		} else {
			if (!defined("BG_DB_PORT")) {
				define("BG_DB_PORT", "3306");
			}

			$_cfg_host = array(
				"host"      => BG_DB_HOST,
				"name"      => BG_DB_NAME,
				"user"      => BG_DB_USER,
				"pass"      => BG_DB_PASS,
				"charset"   => BG_DB_CHARSET,
				"debug"     => BG_DB_DEBUG,
				"port"      => BG_DB_PORT,
			);

			$GLOBALS["obj_db"]   = new CLASS_MYSQLI($_cfg_host); //设置数据库对象
			$this->obj_db        = $GLOBALS["obj_db"];
			if (!$this->obj_db->connect()) {
				return false;
				exit;
			}

			if (!$this->obj_db->select_db()) {
				return false;
				exit;
			}
			return true;
		}
	}


	private function upgrade_init() {
		$_arr_extRow      = get_loaded_extensions();
		$this->errCount   = 0;

		foreach ($this->obj_tpl->type["ext"] as $_key=>$_value) {
			if (!in_array($_key, $_arr_extRow)) {
				$this->errCount++;
			}
		}

		$this->tplData = array(
			"errCount"   => $this->errCount,
			"extRow"     => $_arr_extRow,
		);
	}
}
