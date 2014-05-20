<?php
/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
！！！！警告！！！！
以下为系统文件，请勿修改
+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

/*++++++提示信息++++++
x开头为错误
y开头为成功
++++++++++++++++++*/
return array(
	"x030403" => "<h3>如需重新安装，请执行如下步骤：</h3>
		<ol>
			<li>删除 ./" . BG_NAME_CONFIG . "/is_install.php 文件</li>
			<li>重新运行 <a href=\"" . BG_URL_INSTALL . "install.php\">" . BG_URL_INSTALL . "install.php</a></li>
		<ol>",

	"x030404" => "<h3>数据库未正确设置：</h3>
		<ol>
			<li><a href=\"" . BG_URL_INSTALL . "install.php\">返回重新设置</a></li>
		</ol>",

	"x030408" => "<h3>如需重新安装，请执行如下步骤：</h3>
		<ol>
			<li>删除 " . BG_URL_SSO . "config/is_install.php 文件</li>
			<li>重新运行 <a href=\"" . BG_URL_INSTALL . "install.php?mod=install&act_get=ssoauto\">" . BG_URL_INSTALL . "install.php?mod=install&act_get=ssoauto</a></li>
		<ol>",
);
?>