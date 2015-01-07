<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

/*-------------管理员模型-------------*/
class MODEL_ADMIN {
	private $obj_db;

	function __construct() { //构造函数
		$this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
	}


	function mdl_create() {
		$_arr_adminCreate = array(
			"admin_id"           => "int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID'",
			"admin_name"         => "varchar(30) NOT NULL COMMENT '用户名'",
			"admin_pass"         => "varchar(32) NOT NULL COMMENT '密码'",
			"admin_rand"         => "varchar(6) NOT NULL COMMENT '随机串'",
			"admin_note"         => "varchar(30) NOT NULL COMMENT '备注'",
			"admin_nick"         => "varchar(30) NOT NULL COMMENT '昵称'",
			"admin_status"       => "varchar(20) NOT NULL COMMENT '状态'",
			"admin_allow"        => "varchar(3000) NOT NULL COMMENT '权限'",
			"admin_time"         => "int(11) NOT NULL COMMENT '创建时间'",
			"admin_time_login"   => "int(11) NOT NULL COMMENT '登录时间'",
			"admin_ip"           => "varchar(15) NOT NULL COMMENT '最后IP地址'",
		);

		$_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "admin", $_arr_adminCreate, "admin_id", "管理员");

		if ($_num_mysql > 0) {
			$_str_alert = "y020105"; //更新成功
		} else {
			$_str_alert = "x020105"; //更新成功
		}

		return array(
			"str_alert" => $_str_alert, //更新成功
		);
	}


	function mdl_column() {
		$_arr_colSelect = array(
			"column_name"
		);

		$_str_sqlWhere = "table_schema='" . BG_DB_NAME . "' AND table_name='" . BG_DB_TABLE . "admin'";

		$_arr_colRows = $this->obj_db->select_array("information_schema`.`columns", $_arr_colSelect, $_str_sqlWhere, 100, 0);

		foreach ($_arr_colRows as $_key=>$_value) {
			$_arr_col[] = $_value["column_name"];
		}

		return $_arr_col;
	}


	/**
	 * mdl_login function.
	 *
	 * @access public
	 * @param mixed $num_adminId
	 * @param mixed $str_adminPass
	 * @param mixed $str_adminRand
	 * @return void
	 */
	function mdl_login($num_adminId, $str_adminPass, $str_adminRand) {
		$_arr_adminData = array(
			"admin_pass"         => $str_adminPass,
			"admin_rand"         => $str_adminRand,
			"admin_time_login"   => time(),
			"admin_ip"           => fn_getIp(true),
		);

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "admin", $_arr_adminData, "admin_id=" . $num_adminId); //更新数据
		if ($_num_mysql > 0) {
			$_str_alert = "y020103"; //更新成功
		} else {
			return array(
				"str_alert" => "x020103", //更新失败
			);
			exit;

		}

		return array(
			"admin_id" => $_num_adminId,
			"str_alert" => $_str_alert, //成功
		);
	}


	/**
	 * mdl_profile function.
	 *
	 * @access public
	 * @param mixed $num_adminId
	 * @param string $str_adminPass (default: "")
	 * @param string $str_adminRand (default: "")
	 * @param string $str_adminNote (default: "")
	 * @return void
	 */
	function mdl_profile($num_adminId) {
		$_arr_adminData = array(
			"admin_nick" => $this->adminProfile["admin_nick"],
		);

		$_num_adminId = $num_adminId;
		$_num_mysql   = $this->obj_db->update(BG_DB_TABLE . "admin", $_arr_adminData, "admin_id=" . $_num_adminId); //更新数据
		if ($_num_mysql > 0) {
			$_str_alert = "y020108"; //更新成功
		} else {
			return array(
				"str_alert" => "x020103", //更新失败
			);
			exit;
		}

		return array(
			"admin_id"   => $_num_adminId,
			"str_alert"  => $_str_alert, //成功
		);
	}


	function mdl_pass($num_adminId) {
		$_arr_adminData = array(
			"admin_pass" => $this->adminPass["admin_pass_do"],
			"admin_rand" => $this->adminPass["admin_rand"],
		);

		$_num_adminId = $num_adminId;
		$_num_mysql   = $this->obj_db->update(BG_DB_TABLE . "admin", $_arr_adminData, "admin_id=" . $_num_adminId); //更新数据
		if ($_num_mysql > 0) {
			$_str_alert = "y020109"; //更新成功
		} else {
			return array(
				"str_alert" => "x020103", //更新失败
			);
			exit;
		}

		return array(
			"admin_id"   => $_num_adminId,
			"str_alert"  => $_str_alert, //成功
		);
	}

	/**
	 * mdl_submit function.
	 *
	 * @access public
	 * @param mixed $num_adminId
	 * @param mixed $str_adminName
	 * @param mixed $str_adminPass
	 * @param mixed $str_adminRand (default: fn_rand(6))
	 * @param string $str_adminNote (default: "")
	 * @param string $str_adminStatus (default: "enable")
	 * @param string $str_adminAllow (default: "")
	 * @return void
	 */
	function mdl_submit($str_adminPass = "", $str_adminRand = "") {
		$_arr_adminData = array(
			"admin_name"     => $this->adminSubmit["admin_name"],
			"admin_note"     => $this->adminSubmit["admin_note"],
			"admin_status"   => $this->adminSubmit["admin_status"],
			"admin_allow"    => $this->adminSubmit["admin_allow"],
			"admin_nick"     => $this->adminSubmit["admin_nick"],
		);

		if ($this->adminSubmit["admin_id"] == 0) {
			$_arr_insert = array(
				"admin_pass"        => $str_adminPass,
				"admin_rand"        => $str_adminRand,
				"admin_time"        => time(),
				"admin_time_login"  => time(),
				"admin_ip"          => fn_getIp(),
			);
			$_arr_data = array_merge($_arr_adminData, $_arr_insert);

			$_num_adminId = $this->obj_db->insert(BG_DB_TABLE . "admin", $_arr_data); //更新数据
			if ($_num_adminId > 0) {
				$_str_alert = "y020101"; //更新成功
			} else {
				return array(
					"str_alert" => "x020101", //更新失败
				);
				exit;

			}
		} else {
			if ($str_adminPass) {
				$_arr_adminData["admin_pass"] = $str_adminPass;
			}
			if ($str_adminRand) {
				$_arr_adminData["admin_rand"] = $str_adminRand;
			}
			$_num_adminId    = $this->adminSubmit["admin_id"];
			$_num_mysql      = $this->obj_db->update(BG_DB_TABLE . "admin", $_arr_adminData, "admin_id=" . $_num_adminId); //更新数据
			if ($_num_mysql > 0) {
				$_str_alert = "y020103"; //更新成功
			} else {
				return array(
					"str_alert" => "x020103", //更新失败
				);
				exit;

			}
		}

		return array(
			"admin_id"   => $_num_adminId,
			"str_alert"  => $_str_alert, //成功
		);
	}


	/**
	 * mdl_status function.
	 *
	 * @access public
	 * @param mixed $str_status
	 * @return void
	 */
	function mdl_status($str_status) {
		$_str_adminId = implode(",", $this->adminIds["admin_ids"]);

		$_arr_adminUpdate = array(
			"admin_status" => $str_status,
		);

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "admin", $_arr_adminUpdate, "admin_id IN (" . $_str_adminId . ")"); //删除数据

		//如影响行数大于0则返回成功
		if ($_num_mysql > 0) {
			$_str_alert = "y020103"; //成功
		} else {
			$_str_alert = "x020103"; //失败
		}

		return array(
			"str_alert" => $_str_alert,
		);
	}


	/**
	 * mdl_read function.
	 *
	 * @access public
	 * @param mixed $str_admin
	 * @param string $str_by (default: "admin_id")
	 * @param int $num_notId (default: 0)
	 * @return void
	 */
	function mdl_read($str_admin, $str_by = "admin_id", $num_notId = 0) {
		$_arr_adminSelect = array(
			"admin_id",
			"admin_name",
			"admin_pass",
			"admin_note",
			"admin_nick",
			"admin_rand",
			"admin_time",
			"admin_time_login",
			"admin_ip",
			"admin_allow",
			"admin_status",
		);

		switch ($str_by) {
			case "admin_id":
				$_str_sqlWhere = "admin_id=" . $str_admin;
			break;
			default:
				$_str_sqlWhere = $str_by . "='" . $str_admin . "'";
			break;
		}

		if ($num_notId > 0) {
			$_str_sqlWhere .= " AND admin_id<>" . $num_notId;
		}

		$_arr_adminRows = $this->obj_db->select_array(BG_DB_TABLE . "admin", $_arr_adminSelect, $_str_sqlWhere, 1, 0); //检查本地表是否存在记录
		$_arr_adminRow = $_arr_adminRows[0];

		if (!$_arr_adminRow) { //用户名不存在则返回错误
			return array(
				"str_alert" => "x020102", //不存在记录
			);
			exit;
		}

		$_arr_adminRow["admin_allow"] = json_decode($_arr_adminRow["admin_allow"], true); //json解码
		$_arr_adminRow["str_alert"]   = "y020102";

		return $_arr_adminRow;

	}


	/**
	 * mdl_list function.
	 *
	 * @access public
	 * @param mixed $num_adminNo
	 * @param int $num_adminExcept (default: 0)
	 * @param string $str_key (default: "")
	 * @param string $str_status (default: "")
	 * @return void
	 */
	function mdl_list($num_adminNo, $num_adminExcept = 0, $str_key = "", $str_status = "") {
		$_arr_adminSelect = array(
			"admin_id",
			"admin_name",
			"admin_note",
			"admin_nick",
			"admin_status",
			"admin_time",
			"admin_time_login",
			"admin_ip",
		);

		$_str_sqlWhere = "admin_id > 0";

		if ($str_key) {
			$_str_sqlWhere .= " AND (admin_name LIKE '%" . $str_key . "%' OR admin_note LIKE '%" . $str_key . "%')";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND admin_status='" . $str_status . "'";
		}

		$_arr_adminRows = $this->obj_db->select_array(BG_DB_TABLE . "admin", $_arr_adminSelect, $_str_sqlWhere . " ORDER BY admin_id DESC", $num_adminNo, $num_adminExcept); //查询数据

		return $_arr_adminRows;
	}


	/**
	 * mdl_del function.
	 *
	 * @access public
	 * @return void
	 */
	function mdl_del() {
		$_str_adminId = implode(",", $this->adminIds["admin_ids"]);

		$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "admin", "admin_id IN (" . $_str_adminId . ")"); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y020104"; //成功
		} else {
			$_str_alert = "x020104"; //失败
		}

		return array(
			"str_alert" => $_str_alert,
		);
	}


	/**
	 * mdl_count function.
	 *
	 * @access public
	 * @param string $str_key (default: "")
	 * @param string $str_status (default: "")
	 * @return void
	 */
	function mdl_count($str_key = "", $str_status = "") {
		$_str_sqlWhere = "admin_id > 0";

		if ($str_key) {
			$_str_sqlWhere .= " AND (admin_name LIKE '%" . $str_key . "%' OR admin_note LIKE '%" . $str_key . "%')";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND admin_status='" . $str_status . "'";
		}

		$_num_adminCount = $this->obj_db->count(BG_DB_TABLE . "admin", $_str_sqlWhere); //查询数据

		return $_num_adminCount;
	}


	function input_profile() {
		if (!fn_token("chk")) { //令牌
			return array(
				"str_alert" => "x030102",
			);
			exit;
		}

		$_arr_adminNick = validateStr($_POST["admin_nick"], 0, 30);
		switch ($_arr_adminNick["status"]) {
			case "too_long":
				return array(
					"str_alert" => "x020212",
				);
				exit;
			break;

			case "ok":
				$this->adminProfile["admin_nick"] = $_arr_adminNick["str"];
			break;

		}

		$this->adminProfile["str_alert"]  = "ok";

		return $this->adminProfile;
	}


	function input_pass() {
		if (!fn_token("chk")) { //令牌
			return array(
				"str_alert" => "x030102",
			);
			exit;
		}

		$_arr_adminPassOld = validateStr($_POST["admin_pass"], 1, 0);
		switch ($_arr_adminPassOld["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x020210",
				);
				exit;
			break;

			case "ok":
				$this->adminPass["admin_pass"] = $_arr_adminPassOld["str"];
			break;
		}

		$_arr_adminPassNew = validateStr($_POST["admin_pass_new"], 1, 0);
		switch ($_arr_adminPassNew["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x020213",
				);
				exit;
			break;

			case "ok":
				$this->adminPass["admin_pass_new"] = $_arr_adminPassNew["str"];
			break;
		}

		$_arr_adminPassConfirm = validateStr($_POST["admin_pass_confirm"], 1, 0);
		switch ($_arr_adminPassConfirm["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x020215",
				);
				exit;
			break;

			case "ok":
				$this->adminPass["admin_pass_confirm"] = $_arr_adminPassConfirm["str"];
			break;
		}

		if ($this->adminPass["admin_pass_new"] != $this->adminPass["admin_pass_confirm"]) {
			return array(
				"str_alert" => "x020211",
			);
			exit;
		}

		$this->adminPass["admin_rand"]    = fn_rand(6);
		$this->adminPass["admin_pass_do"] = fn_baigoEncrypt($this->adminPass["admin_pass_new"], $this->adminPass["admin_rand"]);
		$this->adminPass["str_alert"]     = "ok";

		return $this->adminPass;
	}


	/**
	 * input_login function.
	 *
	 * @access public
	 * @return void
	 */
	function input_login() {
		if (!fn_seccode()) { //验证码
			return array(
				"forward"    => $this->adminLogin["forward"],
				"str_alert"  => "x030101",
			);
			exit;
		}

		if (!fn_token("chk")) { //令牌
			return array(
				"forward"    => $this->adminLogin["forward"],
				"str_alert"  => "x030102",
			);
			exit;
		}

		$this->adminLogin["forward"] = fn_getSafe($_POST["forward"], "txt", "");

		if (!$this->adminLogin["forward"]) {
			$this->adminLogin["forward"] = base64_encode(BG_URL_ADMIN . "ctl.php");
		}

		$_arr_adminName = validateStr($_POST["admin_name"], 1, 30, "str", "strDigit");
		switch ($_arr_adminName["status"]) {
			case "too_short":
				return array(
					"forward"   => $this->adminLogin["forward"],
					"str_alert" => "x020201",
				);
				exit;
			break;

			case "too_long":
				return array(
					"forward"   => $this->adminLogin["forward"],
					"str_alert" => "x020202",
				);
				exit;
			break;

			case "format_err":
				return array(
					"forward"   => $this->adminLogin["forward"],
					"str_alert" => "x020203",
				);
				exit;
			break;

			case "ok":
				$this->adminLogin["admin_name"] = $_arr_adminName["str"];
			break;

		}

		$_arr_adminPass = validateStr($_POST["admin_pass"], 1, 0);
		switch ($_arr_adminPass["status"]) {
			case "too_short":
				return array(
					"forward"   => $this->adminLogin["forward"],
					"str_alert" => "x020205",
				);
				exit;
			break;

			case "ok":
				$this->adminLogin["admin_pass"] = $_arr_adminPass["str"];
			break;

		}

		$this->adminLogin["str_alert"]  = "ok";

		return $this->adminLogin;
	}


	/**
	 * input_submit function.
	 *
	 * @access public
	 * @return void
	 */
	function input_submit() {
		if (!fn_token("chk")) { //令牌
			return array(
				"str_alert" => "x030102",
			);
			exit;
		}

		$this->adminSubmit["admin_id"] = fn_getSafe($_POST["admin_id"], "int", 0);

		if ($this->adminSubmit["admin_id"] > 0) {
			//检验用户是否存在
			$_arr_adminRow = $this->mdl_read($this->adminSubmit["admin_id"]);
			if ($_arr_adminRow["str_alert"] != "y020102") {
				return $_arr_adminRow;
			}
		}

		$_arr_adminName = validateStr($_POST["admin_name"], 1, 30);
		switch ($_arr_adminName["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x020201",
				);
				exit;
			break;

			case "too_long":
				return array(
					"str_alert" => "x020202",
				);
				exit;
			break;

			case "ok":
				$this->adminSubmit["admin_name"] = $_arr_adminName["str"];
			break;

		}

		//检验用户名是否重复
		$_arr_adminRow = $this->mdl_read($this->adminSubmit["admin_name"], "admin_name", $this->adminSubmit["admin_id"]);
		if ($_arr_adminRow["str_alert"] == "y020102") {
			return array(
				"str_alert" => "x020204",
			);
			exit;
		}

		$_arr_adminNote = validateStr($_POST["admin_note"], 0, 30);
		switch ($_arr_adminNote["status"]) {
			case "too_long":
				return array(
					"str_alert" => "x020208",
				);
				exit;
			break;

			case "ok":
				$this->adminSubmit["admin_note"] = $_arr_adminNote["str"];
			break;
		}

		$_arr_adminStatus = validateStr($_POST["admin_status"], 1, 0);
		switch ($_arr_adminStatus["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x020209",
				);
				exit;
			break;

			case "ok":
				$this->adminSubmit["admin_status"] = $_arr_adminStatus["str"];
			break;

		}

		$_arr_adminNick = validateStr($_POST["admin_nick"], 0, 30);
		switch ($_arr_adminNick["status"]) {
			case "too_long":
				return array(
					"str_alert" => "x020212",
				);
				exit;
			break;

			case "ok":
				$this->adminSubmit["admin_nick"] = $_arr_adminNick["str"];
			break;
		}

		$this->adminSubmit["admin_allow"] = json_encode($_POST["admin_allow"]);
		$this->adminSubmit["str_alert"]   = "ok";

		return $this->adminSubmit;
	}


	function api_add() {
		if (!fn_token("chk")) { //令牌
			return array(
				"str_alert" => "x030102",
			);
			exit;
		}

		$_arr_adminName = validateStr($_POST["admin_name"], 1, 30);
		switch ($_arr_adminName["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x020201",
				);
				exit;
			break;

			case "too_long":
				return array(
					"str_alert" => "x020202",
				);
				exit;
			break;

			case "ok":
				$this->adminSubmit["admin_name"] = $_arr_adminName["str"];
			break;

		}

		//检验用户名是否重复
		$_arr_adminRow = $this->mdl_read($this->adminSubmit["admin_name"], "admin_name", $this->adminSubmit["admin_id"]);
		if ($_arr_adminRow["str_alert"] == "y020102") {
			$this->adminSubmit["admin_id"] = $_arr_adminRow["admin_id"];
		}

		$this->adminSubmit["admin_status"]    = "enable";
		$this->adminSubmit["admin_pass"]      = $_POST["admin_pass"];

		$_arr_adminAllow = array(
			"user" => array(
				"browse"   => 1,
				"add"      => 1,
				"edit"     => 1,
				"del"      => 1,
			),
			"app" => array(
				"browse"   => 1,
				"add"      => 1,
				"edit"     => 1,
				"del"      => 1,
			),
			"log" => array(
				"browse"   => 1,
				"edit"     => 1,
				"del"      => 1,
			),
			"admin" => array(
				"browse"   => 1,
				"add"      => 1,
				"edit"     => 1,
				"del"      => 1,
			),
			"opt" => array(
				"db"   => 1,
				"base" => 1,
				"reg"  => 1,
			),
		);

		$this->adminSubmit["admin_allow"] = json_encode($_arr_adminAllow);
		$this->adminSubmit["str_alert"]   = "ok";

		return $this->adminSubmit;
	}


	/**
	 * input_ids function.
	 *
	 * @access public
	 * @return void
	 */
	function input_ids() {
		if (!fn_token("chk")) { //令牌
			return array(
				"str_alert" => "x030102",
			);
			exit;
		}

		$_arr_adminIds = $_POST["admin_id"];

		if ($_arr_adminIds) {
			foreach ($_arr_adminIds as $_key=>$_value) {
				$_arr_adminIds[$_key] = fn_getSafe($_value, "int", 0);
			}
			$_str_alert = "ok";
		} else {
			$_str_alert = "none";
		}

		$this->adminIds = array(
			"str_alert"   => $_str_alert,
			"admin_ids"   => $_arr_adminIds
		);

		return $this->adminIds;
	}
}
?>