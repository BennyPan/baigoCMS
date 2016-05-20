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
class MODEL_OPT {

    public $arr_const;
    function __construct() { //构造函数
        $this->obj_dir  = new CLASS_DIR();
    }

    function mdl_const($str_type) {
        $_str_outPut = "<?php" . PHP_EOL;
        foreach ($this->arr_const[$str_type] as $_key=>$_value) {
            if (is_numeric($_value)) {
                $_str_outPut .= "define(\"" . $_key . "\", " . $_value . ");" . PHP_EOL;
            } else {
                $_str_outPut .= "define(\"" . $_key . "\", \"" . str_replace(PHP_EOL, "|", $_value) . "\");" . PHP_EOL;
            }
        }

        if ($str_type == "base") {
            $_str_outPut .= "define(\"BG_SITE_SSIN\", \"" . fn_rand(6) . "\");" . PHP_EOL;
        } else if ($str_type == "visit") {
            if (!isset($this->arr_const[$str_type]["BG_VISIT_FILE"]) && $this->arr_const[$str_type]["BG_VISIT_TYPE"] != "static") {
                $_str_outPut .= "define(\"BG_VISIT_FILE\", \"html\");" . PHP_EOL;
            }
        }

        $_str_outPut = str_replace("||", "", $_str_outPut);

        $_num_size = $this->obj_dir->put_file(BG_PATH_CONFIG, "opt_" . $str_type . ".inc.php", $_str_outPut);

        if ($_num_size > 0) {
            $_str_alert = "y060101";
        } else {
            $_str_alert = "x060101";
        }

        return array(
            "alert" => $_str_alert,
        );
    }


    function mdl_dbconfig() {
        $_str_outPut = "<?php" . PHP_EOL;
        $_str_outPut .= "define(\"BG_DB_HOST\", \"" . $this->dbconfigSubmit["db_host"] . "\");" . PHP_EOL;
        $_str_outPut .= "define(\"BG_DB_NAME\", \"" . $this->dbconfigSubmit["db_name"] . "\");" . PHP_EOL;
        $_str_outPut .= "define(\"BG_DB_PORT\", \"" . $this->dbconfigSubmit["db_port"] . "\");" . PHP_EOL;
        $_str_outPut .= "define(\"BG_DB_USER\", \"" . $this->dbconfigSubmit["db_user"] . "\");" . PHP_EOL;
        $_str_outPut .= "define(\"BG_DB_PASS\", \"" . $this->dbconfigSubmit["db_pass"] . "\");" . PHP_EOL;
        $_str_outPut .= "define(\"BG_DB_CHARSET\", \"" . $this->dbconfigSubmit["db_charset"] . "\");" . PHP_EOL;
        $_str_outPut .= "define(\"BG_DB_TABLE\", \"" . $this->dbconfigSubmit["db_table"] . "\");" . PHP_EOL;

        $_num_size = $this->obj_dir->put_file(BG_PATH_CONFIG, "opt_dbconfig.inc.php", $_str_outPut);

        if ($_num_size > 0) {
            $_str_alert = "y030404";
        } else {
            $_str_alert = "x030404";
        }

        return array(
            "alert" => $_str_alert,
        );
    }


    function mdl_htaccess() {
        $_str_outPut = "# BEGIN baigo CMS" . PHP_EOL;
        $_str_outPut .= "<IfModule mod_rewrite.c>" . PHP_EOL;
            $_str_outPut .= "RewriteEngine On" . PHP_EOL;
            $_str_outPut .= "RewriteBase " . BG_URL_ROOT . PHP_EOL;
            $_str_outPut .= "RewriteRule ^article/id-(\d+)/?.*$ " . BG_URL_ROOT . "index.php?mod=article&act_get=show&article_id=$1 [L]" . PHP_EOL;
            $_str_outPut .= "RewriteRule ^cate/[^\\x00\-\\xff]+/id-(\d+)(/key-([^\\x00\-\\xff^/]*))?(/customs-((\w|%)*))?(/page-(\d+))?/?.*$ " . BG_URL_ROOT . "index.php?mod=cate&act_get=show&cate_id=$1&key=$3&customs=$5&page=$8 [L]" . PHP_EOL;
            $_str_outPut .= "RewriteRule ^tag/tag-([^\\x00\-\\xff^/]*)(/page-(\d+))?/?.*$ " . BG_URL_ROOT . "index.php?mod=tag&act_get=show&tag_name=$1&page=$3 [L]" . PHP_EOL;
            $_str_outPut .= "RewriteRule ^spec/id-(\d+)(/page-(\d+))?/?.*$ " . BG_URL_ROOT . "index.php?mod=spec&act_get=show&spec_id=$1&page=$3 [L]" . PHP_EOL;
            $_str_outPut .= "RewriteRule ^spec(/page-(\d+))?/?.*$ " . BG_URL_ROOT . "index.php?mod=spec&act_get=list&page=$2 [L]" . PHP_EOL;
            $_str_outPut .= "RewriteRule ^search(/key-([^\\x00\-\\xff^/]*))?(/customs-((\w|%)*))?(/cate-(\d+))?(/page-(\d+))?/?.*$ " . BG_URL_ROOT . "index.php?mod=search&act_get=show&key=$2&customs=$4&cate_id=$7&page=$9 [L]" . PHP_EOL;
        $_str_outPut .= "</IfModule>" . PHP_EOL;
        $_str_outPut .= "# END baigo CMS" . PHP_EOL;

        $_num_size = $this->obj_dir->put_file(BG_PATH_ROOT, ".htaccess", $_str_outPut);

        if ($_num_size > 0) {
            $_str_alert = "y060101";
        } else {
            $_str_alert = "x060101";
        }

        return array(
            "alert" => $_str_alert,
        );
    }


    function mdl_over() {
        if (!fn_token("chk")) { //令牌
            return array(
                "alert" => "x030206",
            );
        }

        $_str_outPut = "<?php" . PHP_EOL;
        $_str_outPut .= "define(\"BG_INSTALL_VER\", \"" . PRD_CMS_VER . "\");" . PHP_EOL;
        $_str_outPut .= "define(\"BG_INSTALL_PUB\", " . PRD_CMS_PUB . ");" . PHP_EOL;
        $_str_outPut .= "define(\"BG_INSTALL_TIME\", " . time() . ");" . PHP_EOL;

        $_num_size = $this->obj_dir->put_file(BG_PATH_CONFIG, "is_install.php", $_str_outPut);

        if ($_num_size > 0) {
            $_str_alert = "y060101";
        } else {
            $_str_alert = "x060101";
        }

        return array(
            "alert" => $_str_alert,
        );
    }


    function input_dbconfig() {
        if (!fn_token("chk")) { //令牌
            return array(
                "alert" => "x030206",
            );
        }

        $_arr_dbHost = validateStr(fn_post("db_host"), 1, 900);
        switch ($_arr_dbHost["status"]) {
            case "too_short":
                return array(
                    "alert" => "x060204",
                );
            break;

            case "too_long":
                return array(
                    "alert" => "x060205",
                );
            break;

            case "ok":
                $this->dbconfigSubmit["db_host"] = $_arr_dbHost["str"];
            break;
        }

        $_arr_dbName = validateStr(fn_post("db_name"), 1, 900);
        switch ($_arr_dbName["status"]) {
            case "too_short":
                return array(
                    "alert" => "x060206",
                );
            break;

            case "too_long":
                return array(
                    "alert" => "x060207",
                );
            break;

            case "ok":
                $this->dbconfigSubmit["db_name"] = $_arr_dbName["str"];
            break;
        }

        $_arr_dbPort = validateStr(fn_post("db_port"), 1, 900);
        switch ($_arr_dbPort["status"]) {
            case "too_short":
                return array(
                    "alert" => "x060208",
                );
            break;

            case "too_long":
                return array(
                    "alert" => "x060209",
                );
            break;

            case "ok":
                $this->dbconfigSubmit["db_port"] = $_arr_dbPort["str"];
            break;
        }

        $_arr_dbUser = validateStr(fn_post("db_user"), 1, 900);
        switch ($_arr_dbUser["status"]) {
            case "too_short":
                return array(
                    "alert" => "x060210",
                );
            break;

            case "too_long":
                return array(
                    "alert" => "x060211",
                );
            break;

            case "ok":
                $this->dbconfigSubmit["db_user"] = $_arr_dbUser["str"];
            break;
        }

        $_arr_dbPass = validateStr(fn_post("db_pass"), 1, 900);
        switch ($_arr_dbPass["status"]) {
            case "too_short":
                return array(
                    "alert" => "x060212",
                );
            break;

            case "too_long":
                return array(
                    "alert" => "x060213",
                );
            break;

            case "ok":
                $this->dbconfigSubmit["db_pass"] = $_arr_dbPass["str"];
            break;
        }

        $_arr_dbCharset = validateStr(fn_post("db_charset"), 1, 900);
        switch ($_arr_dbCharset["status"]) {
            case "too_short":
                return array(
                    "alert" => "x060214",
                );
            break;

            case "too_long":
                return array(
                    "alert" => "x060215",
                );
            break;

            case "ok":
                $this->dbconfigSubmit["db_charset"] = $_arr_dbCharset["str"];
            break;
        }

        $_arr_dbTable = validateStr(fn_post("db_table"), 1, 900);
        switch ($_arr_dbTable["status"]) {
            case "too_short":
                return array(
                    "alert" => "x060216",
                );
            break;

            case "too_long":
                return array(
                    "alert" => "x060217",
                );
            break;

            case "ok":
                $this->dbconfigSubmit["db_table"] = $_arr_dbTable["str"];
            break;
        }

        $this->dbconfigSubmit["alert"] = "ok";

        return $this->dbconfigSubmit;
    }


    function input_const($str_type) {
        $this->arr_const = fn_post("opt");

        return $this->arr_const[$str_type];
    }
}
