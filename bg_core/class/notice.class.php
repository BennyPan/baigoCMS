<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}


/*-------------NOTICE 接口类-------------*/
class CLASS_NOTICE {

	/** 验证 app
	 * app_chk function.
	 *
	 * @access public
	 * @param mixed $arr_appGet
	 * @param mixed $arr_appRow
	 * @return void
	 */
	function app_chk($num_appId, $str_appKey) {

		$_arr_appId = validateStr($num_appId, 1, 0, "str", "int");
		switch ($_arr_appId["status"]) {
			case "too_short":
				return array(
					"alert" => "x220206",
				);
				exit;
			break;

			case "format_err":
				return array(
					"alert" => "x220207",
				);
				exit;
			break;

			case "ok":
				$_arr_appChk["app_id"] = $_arr_appId["str"];
			break;
		}

		if ($_arr_appChk["app_id"] != BG_SSO_APPID) {
			return array(
				"alert" => "x220208",
			);
			exit;
		}

		$_arr_appKey = validateStr($str_appKey, 1, 64, "str", "alphabetDigit");
		switch ($_arr_appKey["status"]) {
			case "too_short":
				return array(
					"alert" => "x220209",
				);
				exit;
			break;

			case "too_long":
				return array(
					"alert" => "x220210",
				);
				exit;
			break;

			case "format_err":
				return array(
					"alert" => "x220211",
				);
				exit;
			break;

			case "ok":
				$_arr_appChk["app_key"] = $_arr_appKey["str"];
			break;
		}

		if ($_arr_appChk["app_key"] != BG_SSO_APPKEY) {
			return array(
				"alert" => "x220212",
			);
			exit;
		}

		$_arr_appChk["alert"] = "ok";

		return $_arr_appChk;
	}


	/** 读取 app 信息
	 * app_get function.
	 *
	 * @access public
	 * @param bool $chk_token (default: false)
	 * @return void
	 */
	function notice_input($str_method = "get", $chk_token = false) {

        switch ($str_method) {
            case "post":
                $_str_time      = fn_post("time");
                $_str_random    = fn_post("random");
                $_str_signature = fn_post("signature");
                $_str_code      = fn_post("code");
                $_str_key       = fn_post("key");
            break;

            default:
                $_str_time      = fn_get("time");
                $_str_random    = fn_get("random");
                $_str_signature = fn_get("signature");
                $_str_code      = fn_get("code");
                $_str_key       = fn_get("key");
            break;
        }

		$_arr_time = validateStr($_str_time, 1, 0);
		switch ($_arr_time["status"]) {
			case "too_short":
				return array(
					"alert" => "x220201",
				);
				exit;
			break;

			case "ok":
				$_arr_noticeGet["time"] = $_arr_time["str"];
			break;
		}

		$_arr_random = validateStr($_str_random, 1, 0);
		switch ($_arr_random["status"]) {
			case "too_short":
				return array(
					"alert" => "x220202",
				);
				exit;
			break;

			case "ok":
				$_arr_noticeGet["random"] = $_arr_random["str"];
			break;
		}

		$_arr_signature = validateStr($_str_signature, 1, 0);
		switch ($_arr_signature["status"]) {
			case "too_short":
				return array(
					"alert" => "x220203",
				);
				exit;
			break;

			case "ok":
				$_arr_noticeGet["signature"] = $_arr_signature["str"];
			break;
		}

		$_arr_code = validateStr($_str_code, 1, 0);
		switch ($_arr_code["status"]) {
			case "too_short":
				return array(
					"alert" => "x220204",
				);
				exit;
			break;

			case "ok":
				$_arr_noticeGet["code"] = $_arr_code["str"];
			break;
		}

		$_arr_key = validateStr($_str_key, 1, 0);
		switch ($_arr_key["status"]) {
			case "too_short":
				return array(
					"alert" => "x220205",
				);
				exit;
			break;

			case "ok":
				$_arr_noticeGet["key"] = $_arr_key["str"];
			break;
		}

		$_arr_noticeGet["alert"] = "ok";

		return $_arr_noticeGet;
	}


	/** 返回结果
	 * halt_re function.
	 *
	 * @access public
	 * @param mixed $arr_re
	 * @return void
	 */
	function halt_re($arr_re, $is_encode = false) {
		if ($is_encode) {
			$_str_return = fn_jsonEncode($arr_re, "encode");
		} else {
			$_str_return = json_encode($arr_re);
		}
		exit($_str_return); //输出错误信息
	}


	function chk_install() {
		if (file_exists(BG_PATH_CONFIG . "is_install.php")) { //验证是否已经安装
			include_once(BG_PATH_CONFIG . "is_install.php");
			if (!defined("BG_INSTALL_PUB") || PRD_CMS_PUB > BG_INSTALL_PUB) {
				$_arr_return = array(
					"alert" => "x030416"
				);
				$this->halt_re($_arr_return);
			}
		} else {
			$_arr_return = array(
				"alert" => "x030415"
			);
			$this->halt_re($_arr_return);
		}
	}
}