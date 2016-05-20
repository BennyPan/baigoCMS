<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_FUNC . "init.func.php");
$arr_set = array(
    "base"          => true,
    "header"        => "Content-type: application/json; charset=utf-8",
    "db"            => true,
    "type"          => "ajax",
);
fn_init($arr_set);


include_once(BG_PATH_CONTROL . "api/article.class.php"); //载入文章类

$api_article = new API_ARTICLE();

switch ($GLOBALS["act_get"]) {
    case "read":
    case "get":
        $api_article->api_read();
    break;

    default:
        $api_article->api_list();
    break;
}
