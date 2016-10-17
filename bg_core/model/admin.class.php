<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

/*-------------管理员类-------------*/
class MODEL_ADMIN {
    private $obj_db;
    public $adminStatus = array();
    public $adminTypes = array();

    function __construct() { //构造函数
        $this->obj_db     = $GLOBALS["obj_db"]; //设置数据库对象
    }


    /** 创建表
     * mdl_create_table function.
     *
     * @access public
     * @return void
     */
    function mdl_create_table() {
        foreach ($this->adminStatus as $_key=>$_value) {
            $_arr_status[] = $_key;
        }
        $_str_status = implode("','", $_arr_status);

        foreach ($this->adminTypes as $_key=>$_value) {
            $_arr_types[] = $_key;
        }
        $_str_types = implode("','", $_arr_types);

        $_arr_adminCreate = array(
            "admin_id"              => "int NOT NULL AUTO_INCREMENT COMMENT 'ID'",
            "admin_name"            => "varchar(30) NOT NULL COMMENT '用户名'",
            "admin_note"            => "varchar(30) NOT NULL COMMENT '备注'",
            "admin_nick"            => "varchar(30) NOT NULL COMMENT '昵称'",
            "admin_rand"            => "char(6) NOT NULL COMMENT '随机码'",
            "admin_allow_cate"      => "text NOT NULL COMMENT '栏目权限'",
            "admin_group_id"        => "smallint NOT NULL COMMENT '从属用户组ID'",
            "admin_time"            => "int NOT NULL COMMENT '登录时间'",
            "admin_time_login"      => "int NOT NULL COMMENT '最后登录'",
            "admin_status"          => "enum('" . $_str_status . "') NOT NULL COMMENT '状态'",
            "admin_type"            => "enum('" . $_str_types . "') NOT NULL COMMENT '类型'",
            "admin_ip"              => "char(15) NOT NULL COMMENT 'IP'",
            "admin_allow_profile"   => "varchar(1000) NOT NULL COMMENT '个人权限'",
        );

        $_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "admin", $_arr_adminCreate, "admin_id", "管理帐号");

        if ($_num_mysql > 0) {
            $_str_alert = "y020105"; //更新成功
        } else {
            $_str_alert = "x020105"; //更新成功
        }

        return array(
            "alert" => $_str_alert, //更新成功
        );
    }


    /** 列出字段
     * mdl_column function.
     *
     * @access public
     * @return void
     */
    function mdl_column() {
        $_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . "admin");

        foreach ($_arr_colRows as $_key=>$_value) {
            $_arr_col[] = $_value["Field"];
        }

        return $_arr_col;
    }


    /** 修改表
     * mdl_alert_table function.
     *
     * @access public
     * @return void
     */
    function mdl_alert_table() {
        foreach ($this->adminStatus as $_key=>$_value) {
            $_arr_status[] = $_key;
        }
        $_str_status = implode("','", $_arr_status);

        foreach ($this->adminTypes as $_key=>$_value) {
            $_arr_types[] = $_key;
        }
        $_str_types = implode("','", $_arr_types);

        $_arr_col     = $this->mdl_column();
        $_arr_alert   = array();

        if (!in_array("admin_allow_profile", $_arr_col)) {
            $_arr_alert["admin_allow_profile"] = array("ADD", "varchar(1000) NOT NULL COMMENT '个人权限'");
        }

        if (!in_array("admin_nick", $_arr_col)) {
            $_arr_alert["admin_nick"] = array("ADD", "varchar(30) NOT NULL COMMENT '昵称'");
        }

        if (in_array("admin_id", $_arr_col)) {
            $_arr_alert["admin_id"] = array("CHANGE", "int NOT NULL AUTO_INCREMENT COMMENT 'ID'", "admin_id");
        }

        if (in_array("admin_group_id", $_arr_col)) {
            $_arr_alert["admin_group_id"] = array("CHANGE", "smallint NOT NULL COMMENT '从属用户组ID'", "admin_group_id");
        }

        if (in_array("admin_status", $_arr_col)) {
            $_arr_alert["admin_status"] = array("CHANGE", "enum('" . $_str_status . "') NOT NULL COMMENT '状态'", "admin_status");
        }

        if (in_array("admin_rand", $_arr_col)) {
            $_arr_alert["admin_rand"] = array("CHANGE", "char(6) NOT NULL COMMENT '随机码'", "admin_rand");
        }

        if (in_array("admin_ip", $_arr_col)) {
            $_arr_alert["admin_ip"] = array("CHANGE", "char(15) NOT NULL COMMENT 'IP'", "admin_ip");
        }

        if (in_array("admin_allow_cate", $_arr_col)) {
            $_arr_alert["admin_allow_cate"] = array("CHANGE", "text NOT NULL COMMENT '栏目权限'", "admin_allow_cate");
        }

        if (!in_array("admin_type", $_arr_col)) {
            $_arr_alert["admin_type"] = array("ADD", "enum('" . $_str_types . "') NOT NULL COMMENT '类型'");
        }

        $_str_alert = "y020111";

        if ($_arr_alert) {
            $_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "admin", $_arr_alert);

            if ($_reselt) {
                $_str_alert = "y020106";
                $_arr_adminData = array(
                    "admin_status" => $_arr_status[0],
                );
                $this->obj_db->update(BG_DB_TABLE . "admin", $_arr_adminData, "LENGTH(admin_status) < 1"); //更新数据

                $_arr_adminData = array(
                    "admin_type" => $_arr_types[0],
                );
                $this->obj_db->update(BG_DB_TABLE . "admin", $_arr_adminData, "LENGTH(admin_type) < 1"); //更新数据
            }
        }

        return array(
            "alert" => $_str_alert,
        );
    }


    /** 登录处理
     * mdl_login function.
     *
     * @access public
     * @param mixed $num_adminId
     * @param mixed $str_rand
     * @return void
     */
    function mdl_login($num_adminId, $str_rand) {

        $_arr_adminUpdate = array(
            "admin_time_login"   => time(),
            "admin_ip"           => fn_getIp(),
            "admin_rand"         => $str_rand,
        );

        $_num_mysql = $this->obj_db->update(BG_DB_TABLE . "admin", $_arr_adminUpdate, "admin_id=" . $num_adminId); //更新数据

        if ($_num_mysql > 0) {
            $_str_alert = "y020103"; //更新成功
        } else {
            $_str_alert = "x020103"; //更新成功
        }

        return array(
            "alert" => $_str_alert, //更新成功
        );
    }


    /** 修改个人信息
     * mdl_profile function.
     *
     * @access public
     * @param mixed $num_adminId
     * @return void
     */
    function mdl_profile($num_adminId) {

        $_arr_adminData = array(
            "admin_nick" => $this->adminProfile["admin_nick"],
        );

        $_num_mysql = $this->obj_db->update(BG_DB_TABLE . "admin", $_arr_adminData, "admin_id=" . $num_adminId); //更新数据
        if ($_num_mysql > 0) {
            $_str_alert = "y020103"; //更新成功
        } else {
            $_str_alert = "x020103"; //更新失败
        }

        return array(
            "alert"  => $_str_alert, //成功
        );
    }


    /** 提交
     * mdl_submit function.
     *
     * @access public
     * @param mixed $num_adminId
     * @return void
     */
    function mdl_submit($num_adminId) {

        $_arr_adminRow = $this->mdl_read($num_adminId);

        $_arr_adminData = array(
            "admin_note"            => $this->adminSubmit["admin_note"],
            "admin_nick"            => $this->adminSubmit["admin_nick"],
            "admin_status"          => $this->adminSubmit["admin_status"],
            "admin_type"            => $this->adminSubmit["admin_type"],
            "admin_allow_cate"      => $this->adminSubmit["admin_allow_cate"],
            "admin_allow_profile"   => $this->adminSubmit["admin_allow_profile"],
        );

        if ($_arr_adminRow["alert"] == "x020102") {
            $_arr_insert = array(
                "admin_id"      => $num_adminId,
                "admin_rand"    => fn_rand(6),
                "admin_name"    => $this->adminSubmit["admin_name"],
                "admin_time"    => time(),
            );
            $_arr_data       = array_merge($_arr_adminData, $_arr_insert);
            $_num_adminId    = $this->obj_db->insert(BG_DB_TABLE . "admin", $_arr_data); //插入数据
            if ($_num_adminId >= 0) {
                $_str_alert = "y020101"; //插入成功
            } else {
                return array(
                    "alert" => "x020101", //更新失败
                );
            }
        } else {
            $_num_adminId    = $num_adminId;
            $_num_mysql      = $this->obj_db->update(BG_DB_TABLE . "admin", $_arr_adminData, "admin_id=" . $_num_adminId); //更新数据
            if ($_num_mysql > 0) {
                $_str_alert = "y020103"; //更新成功
            } else {
                return array(
                    "alert" => "x020103", //更新失败
                );
            }
        }

        return array(
            "admin_id"  => $_num_adminId,
            "alert"     => $_str_alert, //成功
        );
    }


    /** 加入到组
     * mdl_toGroup function.
     *
     * @access public
     * @param mixed $num_adminId
     * @param mixed $num_groupId
     * @return void
     */
    function mdl_toGroup($num_adminId, $num_groupId) {

        $_arr_adminData = array(
            "admin_group_id"  => $num_groupId,
        );

        $_num_mysql = $this->obj_db->update(BG_DB_TABLE . "admin", $_arr_adminData, "admin_id=" . $num_adminId); //更新数据
        if ($_num_mysql > 0) {
            $_str_alert = "y020103"; //更新成功
        } else {
            return array(
                "alert" => "x020103", //更新失败
            );
        }

        return array(
            "admin_id"  => $num_adminId,
            "alert"     => $_str_alert, //成功
        );
    }


    /** 状态修改
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

        //如车影响行数小于0则返回错误
        if ($_num_mysql > 0) {
            $_str_alert = "y020103";
        } else {
            $_str_alert = "x020103";
        }

        return array(
            "alert" => $_str_alert,
        ); //成功

    }


    /** 读取
     * mdl_read function.
     *
     * @access public
     * @param mixed $num_adminId
     * @return void
     */
    function mdl_read($num_adminId) {

        $_arr_adminSelect = array(
            "admin_id",
            "admin_name",
            "admin_note",
            "admin_nick",
            "admin_rand",
            "admin_group_id",
            "admin_status",
            "admin_type",
            "admin_time",
            "admin_ip",
            "admin_allow_cate",
            "admin_allow_profile",
        );

        $_arr_adminRows = $this->obj_db->select(BG_DB_TABLE . "admin", $_arr_adminSelect, "admin_id=" . $num_adminId, "", "", 1, 0); //检查本地表是否存在记录

        if (isset($_arr_adminRows[0])) { //用户名不存在则返回错误
            $_arr_adminRow = $_arr_adminRows[0];
        } else {
            return array(
                "alert" => "x020102", //不存在记录
            );
        }

        if (fn_isEmpty($_arr_adminRow["admin_allow_cate"])) {
            $_arr_adminRow["admin_allow_cate"]    = array();
        } else {
            $_arr_adminRow["admin_allow_cate"]    = fn_jsonDecode($_arr_adminRow["admin_allow_cate"], "no"); //json解码
        }

        if (fn_isEmpty($_arr_adminRow["admin_allow_profile"])) {
            $_arr_adminRow["admin_allow_profile"] = array();
        } else {
            $_arr_adminRow["admin_allow_profile"] = fn_jsonDecode($_arr_adminRow["admin_allow_profile"], "no"); //json解码
        }

        $_arr_adminRow["alert"] = "y020102";

        return $_arr_adminRow;

    }


    function mdl_prefer() {
        foreach ($this->arr_prefer as $_key=>$_value) {
            foreach ($_value as $_key_s=>$_value_s) {
                fn_cookie("prefer_" . $_key . "_" . $_key_s, "mk", $_value_s);
            }
        }

        $_arr_adminRow["alert"] = "y020112";

        return $_arr_adminRow;
    }


    /** 列出
     * mdl_list function.
     *
     * @access public
     * @param mixed $num_no
     * @param int $num_except (default: 0)
     * @param array $arr_search (default: array())
     * @return void
     */
    function mdl_list($num_no, $num_except = 0, $arr_search = array()) {

        $_arr_adminSelect = array(
            "admin_id",
            "admin_name",
            "admin_note",
            "admin_nick",
            "admin_group_id",
            "admin_status",
            "admin_type",
        );

        $_str_sqlWhere = $this->sql_process($arr_search);

        $_arr_order = array(
            array("admin_id", "DESC"),
        );

        $_arr_adminRows = $this->obj_db->select(BG_DB_TABLE . "admin", $_arr_adminSelect, $_str_sqlWhere, "", $_arr_order, $num_no, $num_except); //查询数据

        //print_r($_arr_adminRows);

        return $_arr_adminRows;

    }


    /** 统计
     * mdl_count function.
     *
     * @access public
     * @param array $arr_search (default: array())
     * @return void
     */
    function mdl_count($arr_search = array()) {
        $_str_sqlWhere = $this->sql_process($arr_search);

        $_num_count = $this->obj_db->count(BG_DB_TABLE . "admin", $_str_sqlWhere); //查询数据

        return $_num_count;
    }


    /** 删除
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
            $_str_alert = "y020104";
        } else {
            $_str_alert = "x020104";
        }

        return array(
            "alert" => $_str_alert,
        ); //成功

    }


    /** 个人信息输入
     * input_profile function.
     *
     * @access public
     * @return void
     */
    function input_profile() {
        if (!fn_token("chk")) { //令牌
            return array(
                "alert" => "x030206",
            );
        }

        $_arr_adminNick = validateStr(fn_post("admin_nick"), 0, 30);
        switch ($_arr_adminNick["status"]) {
        case "too_long":
            return array(
                "alert" => "x020216",
            );
            break;

        case "ok":
            $this->adminProfile["admin_nick"] = $_arr_adminNick["str"];
            break;
        }

        $_arr_adminMail = validateStr(fn_post("admin_mail"), 0, 900, "str", "email");
        switch ($_arr_adminMail["status"]) {
        case "too_long":
            return array(
                "alert" => "x020208",
            );
            break;

        case "format_err":
            return array(
                "alert" => "x020209",
            );
            break;

        case "ok":
            $this->adminProfile["admin_mail"] = $_arr_adminMail["str"];
            break;
        }

        $this->adminProfile["alert"] = "ok";

        return $this->adminProfile;
    }


    /** 修改密码输入
     * input_pass function.
     *
     * @access private
     * @return void
     */
    function input_pass() {
        if (!fn_token("chk")) { //令牌
            return array(
                "alert" => "x030206",
            );
        }

        $_arr_adminPassOld = validateStr(fn_post("admin_pass"), 1, 0);
        switch ($_arr_adminPassOld["status"]) {
        case "too_short":
            return array(
                "alert" => "x020210",
            );
            break;

        case "ok":
            $_arr_adminPass["admin_pass"] = $_arr_adminPassOld["str"];
            break;
        }

        $_arr_adminPassNew = validateStr(fn_post("admin_pass_new"), 1, 0);
        switch ($_arr_adminPassNew["status"]) {
        case "too_short":
            return array(
                "alert" => "x020217",
            );
            break;

        case "ok":
            $_arr_adminPass["admin_pass_new"] = $_arr_adminPassNew["str"];
            break;
        }

        $_arr_adminPassConfirm = validateStr(fn_post("admin_pass_confirm"), 1, 0);
        switch ($_arr_adminPassConfirm["status"]) {
        case "too_short":
            return array(
                "alert" => "x020215",
            );
            break;

        case "ok":
            $_arr_adminPass["admin_pass_confirm"] = $_arr_adminPassConfirm["str"];
            break;
        }

        if ($_arr_adminPass["admin_pass_new"] != $_arr_adminPass["admin_pass_confirm"]) {
            return array(
                "alert" => "x020211",
            );
        }

        $_arr_adminPass["alert"] = "ok";

        return $_arr_adminPass;
    }


    /** 提交输入
     * input_submit function.
     *
     * @access public
     * @return void
     */
    function input_submit() {
        if (!fn_token("chk")) { //令牌
            return array(
                "alert" => "x030206",
            );
        }

        $this->adminSubmit["admin_id"] = fn_getSafe(fn_post("admin_id"), "int", 0);

        if ($this->adminSubmit["admin_id"] > 0) {
            $_arr_adminRow = $this->mdl_read($this->adminSubmit["admin_id"]);
            if ($_arr_adminRow["alert"] != "y020102") {
                return $_arr_adminRow;
            }
        }

        $_arr_adminName = validateStr(fn_post("admin_name"), 1, 30, "str", "strDigit");
        switch ($_arr_adminName["status"]) {
        case "too_short":
            return array(
                "alert" => "x020201",
            );
            break;

        case "too_long":
            return array(
                "alert" => "x020202",
            );
            break;

        case "format_err":
            return array(
                "alert" => "x020203",
            );
            break;

        case "ok":
            $this->adminSubmit["admin_name"] = $_arr_adminName["str"];
            break;
        }

        $_arr_adminMail = validateStr(fn_post("admin_mail"), 0, 900, "str", "email");
        switch ($_arr_adminMail["status"]) {
        case "too_long":
            return array(
                "alert" => "x020208",
            );
            break;

        case "format_err":
            return array(
                "alert" => "x020209",
            );
            break;

        case "ok":
            $this->adminSubmit["admin_mail"] = $_arr_adminMail["str"];
            break;

        }

        $_arr_adminNick = validateStr(fn_post("admin_nick"), 0, 30);
        switch ($_arr_adminNick["status"]) {
        case "too_long":
            return array(
                "alert" => "x020216",
            );
            break;

        case "ok":
            $this->adminSubmit["admin_nick"] = $_arr_adminNick["str"];
            break;
        }

        $_arr_adminNote = validateStr(fn_post("admin_note"), 0, 30);
        switch ($_arr_adminNote["status"]) {
        case "too_long":
            return array(
                "alert" => "x020212",
            );
            break;

        case "ok":
            $this->adminSubmit["admin_note"] = $_arr_adminNote["str"];
            break;
        }

        $_arr_adminStatus = validateStr(fn_post("admin_status"), 1, 0);
        switch ($_arr_adminStatus["status"]) {
        case "too_short":
            return array(
                "alert" => "x020213",
            );
            break;

        case "ok":
            $this->adminSubmit["admin_status"] = $_arr_adminStatus["str"];
            break;
        }

        $_arr_adminType = validateStr(fn_post("admin_type"), 1, 0);
        switch ($_arr_adminType["status"]) {
        case "too_short":
            return array(
                "alert" => "x020219",
            );
            break;

        case "ok":
            $this->adminSubmit["admin_type"] = $_arr_adminType["str"];
            break;
        }

        $this->adminSubmit["admin_allow_cate"]      = fn_jsonEncode(fn_post("admin_allow_cate"), "no");
        $this->adminSubmit["admin_allow_profile"]   = fn_jsonEncode(fn_post("admin_allow_profile"), "no");
        $this->adminSubmit["alert"]                 = "ok";

        return $this->adminSubmit;
    }


    /** 登录输入
     * input_login function.
     *
     * @access public
     * @return void
     */
    function input_login() {
        $_arr_adminLogin["forward"] = fn_getSafe(fn_post("forward"), "txt", "");
        if (fn_isEmpty($_arr_adminLogin["forward"])) {
            $_arr_adminLogin["forward"] = fn_forward(BG_URL_ADMIN . "ctl.php");
        }

        //$_arr_adminLogin["forward"] = str_ireplace("&#61;", "", $_arr_adminLogin["forward"]);

        if (!fn_seccode()) { //验证码
            return array(
                "forward"   => $_arr_adminLogin["forward"],
                "alert"     => "x030205",
            );
        }

        if (!fn_token("chk")) { //令牌
            return array(
                "forward"   => $_arr_adminLogin["forward"],
                "alert"     => "x030206",
            );
        }

        $_arr_adminName = validateStr(fn_post("admin_name"), 1, 30, "str", "strDigit");
        switch ($_arr_adminName["status"]) {
        case "too_short":
            return array(
                "forward"   => $_arr_adminLogin["forward"],
                "alert"     => "x020201",
            );
            break;

        case "too_long":
            return array(
                "forward"   => $_arr_adminLogin["forward"],
                "alert"     => "x020202",
            );
            break;

        case "format_err":
            return array(
                "forward"   => $_arr_adminLogin["forward"],
                "alert"     => "x020203",
            );
            break;

        case "ok":
            $_arr_adminLogin["admin_name"] = $_arr_adminName["str"];
            break;

        }

        $_arr_adminPass = validateStr(fn_post("admin_pass"), 1, 0);
        switch ($_arr_adminPass["status"]) {
        case "too_short":
            return array(
                "forward"   => $_arr_adminLogin["forward"],
                "alert"     => "x020208",
            );
            break;

        case "ok":
            $_arr_adminLogin["admin_pass"] = $_arr_adminPass["str"];
            break;

        }

        $_arr_adminLogin["alert"] = "ok";

        return $_arr_adminLogin;
    }


    function input_prefer() {
        $this->arr_prefer = fn_post("prefer");

        return $this->arr_prefer;
    }


    /** 批量操作选择
     * input_ids function.
     *
     * @access public
     * @return void
     */
    function input_ids() {
        if (!fn_token("chk")) { //令牌
            return array(
                "alert" => "x030206",
            );
        }

        $_arr_adminIds = fn_post("admin_ids");

        if ($_arr_adminIds) {
            foreach ($_arr_adminIds as $_key=>$_value) {
                $_arr_adminIds[$_key] = fn_getSafe($_value, "int", 0);
            }
            $_str_alert = "ok";
        } else {
            $_str_alert = "x030202";
        }

        $this->adminIds = array(
            "alert"     => $_str_alert,
            "admin_ids" => $_arr_adminIds
        );

        return $this->adminIds;
    }


    /** 列出及统计 SQL 处理
     * sql_process function.
     *
     * @access private
     * @param array $arr_search (default: array())
     * @return void
     */
    private function sql_process($arr_search = array()) {
        $_str_sqlWhere = "1=1";

        if (isset($arr_search["key"]) && !fn_isEmpty($arr_search["key"])) {
            $_str_sqlWhere .= " AND (admin_name LIKE '%" . $arr_search["key"] . "%' OR admin_note LIKE '%" . $arr_search["key"] . "%' OR admin_nick LIKE '%" . $arr_search["key"] . "%')";
        }

        if (isset($arr_search["status"]) && !fn_isEmpty($arr_search["status"])) {
            $_str_sqlWhere .= " AND admin_status='" . $arr_search["status"] . "'";
        }

        if (isset($arr_search["type"]) && !fn_isEmpty($arr_search["type"])) {
            $_str_sqlWhere .= " AND admin_type='" . $arr_search["type"] . "'";
        }

        if (isset($arr_search["group_id"]) && $arr_search["group_id"] > 0) {
            $_str_sqlWhere .= " AND admin_group_id=" . $arr_search["group_id"];
        }

        return $_str_sqlWhere;
    }
}
