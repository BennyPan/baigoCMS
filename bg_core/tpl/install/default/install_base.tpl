{* install_1.tpl 登录界面 *}
{$cfg = [
	sub_title  => $lang.page.installBase,
	sub_active => "base",
	mod_help   => "install",
	act_help   => "base"
]}
{include "{$smarty.const.BG_PATH_SYSTPL_INSTALL}default/include/install_head.tpl" cfg=$cfg}

	<form name="install_form_base" id="install_form_base">
		<input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
		<input type="hidden" name="act_post" value="base">

		{include "{$smarty.const.BG_PATH_SYSTPL_INSTALL}default/include/install_form.tpl" cfg=$cfg}

		<div class="form-group">
			<label for="opt_BG_SITE_TPL" class="control-label">{$lang.label.tpl}<span id="msg_BG_SITE_TPL">*</span></label>
			<select name="opt[BG_SITE_TPL]" id="opt_BG_SITE_TPL" class="validate form-control input-lg">
				{foreach $tplData.tplRows as $key=>$value}
					{if $value["type"] == "dir"}
						<option {if $smarty.const.BG_SITE_TPL == $value.name}selected{/if} value="{$value.name}">{$value.name}</option>
					{/if}
				{/foreach}
			</select>
		</div>

		<div class="form-group">
			<label for="opt_BG_SITE_EXCERPTTYPE" class="control-label">{$lang.label.excerptDefault}<span id="msg_BG_SITE_EXCERPTTYPE">*</span></label>
			<select name="opt[BG_SITE_EXCERPTTYPE]" id="opt_BG_SITE_EXCERPTTYPE" class="validate form-control">
				{foreach $tplData.excerptType as $key=>$value}
					<option {if $smarty.const.BG_SITE_EXCERPTTYPE == $key}selected{/if} value="{$key}">{$value}</option>
				{/foreach}
			</select>
		</div>

		<div class="form-group">
			<div class="btn-group">
				<button type="button" id="go_next" class="btn btn-primary btn-lg">{$lang.btn.save}</button>
				{include "{$smarty.const.BG_PATH_SYSTPL_INSTALL}default/include/install_drop.tpl" cfg=$cfg}
			</div>
		</div>
	</form>

{include "{$smarty.const.BG_PATH_SYSTPL_INSTALL}default/include/install_foot.tpl" cfg=$cfg}

	<script type="text/javascript">
	opts_validator_form.opt_BG_SITE_TPL = {
		length: { min: 1, max: 900 },
		validate: { type: "select" },
		msg: { id: "msg_BG_SITE_TPL", too_few: "{$alert.x060201}{$lang.label.tpl}" }
	};

	var opts_submit_form = {
		ajax_url: "{$smarty.const.BG_URL_INSTALL}ajax.php?mod=install",
		text_submitting: "{$lang.label.submitting}",
		btn_text: "{$lang.btn.stepNext}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$smarty.const.BG_URL_INSTALL}ctl.php?mod=install&act_get=visit"
	};

	$(document).ready(function(){
		var obj_validator_form = $("#install_form_base").baigoValidator(opts_validator_form);
		var obj_submit_form = $("#install_form_base").baigoSubmit(opts_submit_form);
		$("#go_next").click(function(){
			if (obj_validator_form.validateSubmit()) {
				obj_submit_form.formSubmit();
			}
		});
	})
	</script>

</html>
