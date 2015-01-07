{* html_foot.tpl HTML 底部通用 *}

	{if $cfg.baigoValidator}
		<!--表单验证 js-->
		<script src="{$smarty.const.BG_URL_JS}baigoValidator/baigoValidator.js" type="text/javascript"></script>
	{/if}

	{if $cfg.baigoSubmit}
		<!--表单 ajax 提交 js-->
		<script src="{$smarty.const.BG_URL_JS}baigoSubmit/baigoSubmit.js" type="text/javascript"></script>
	{/if}

	{if $cfg.reloadImg}
		<!--重新载入图片 js-->
		<script src="{$smarty.const.BG_URL_JS}reloadImg.js" type="text/javascript"></script>
	{/if}

	{if $cfg.baigoCheckall}
		<!--全选 js-->
		<script src="{$smarty.const.BG_URL_JS}baigoCheckall.js" type="text/javascript"></script>
	{/if}

	<script type="text/javascript">
	function tokenReload() {
		$.getJSON("{$smarty.const.BG_URL_ADMIN}ajax.php?mod=token&act_get=make", function(result){
			var _token = $("form input.token_session").val();
			if (result.alert == "y030102") {
				if (_token != result.token) {
					//alert(result.str_alert);
					$("form input.token_session").val(result.token);
				}
			} else {
				alert(result.msg);
			}
		});
		setTimeout("tokenReload();", 300000);
	}

	$(document).ready(function(){
		setTimeout("tokenReload();", 300000);
	});
	</script>

	<script src="{$smarty.const.BG_URL_JS}bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

</html>