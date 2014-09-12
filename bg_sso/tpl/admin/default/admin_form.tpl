{* admin_form.tpl 管理员编辑界面 *}
{if $tplData.adminRow.admin_id == 0}
	{$title_sub    = $lang.page.add}
	{$str_sub      = "form"}
{else}
	{$title_sub    = $lang.page.edit}
	{$str_sub      = "list"}
{/if}

{$cfg = [
	title          => "{$adminMod.admin.main.title} - {$title_sub}",
	menu_active    => "admin",
	sub_active     => $str_sub,
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=admin"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=admin&act_get=list">{$adminMod.admin.main.title}</a></li>
	<li>{$title_sub}</li>

	{include "include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<ul class="list-inline">
			<li>
				<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=admin&act_get=list">
					<span class="glyphicon glyphicon-chevron-left"></span>
					{$lang.href.back}
				</a>
			</li>
			<li>
				<a href="{$smarty.const.BG_URL_HELP}?lang=zh_CN&mod=help&act=admin#form" target="_blank">
					<span class="glyphicon glyphicon-question-sign"></span>
					{$lang.href.help}
				</a>
			</li>
		</ul>
	</div>

	<form name="admin_form" id="admin_form" autocomplete="off">

		<input type="hidden" name="token_session" value="{$common.token_session}">
		<input type="hidden" name="act_post" value="submit">
		<input type="hidden" name="admin_id" value="{$tplData.adminRow.admin_id}">

		<div class="row">
			<div class="col-md-9">
				<div class="panel panel-default">
					<div class="panel-body">
						{if $tplData.adminRow.admin_id > 0}
							<div class="form-group">
								<label class="control-label">{$lang.label.username}</label>
								<input type="text" name="admin_name" id="admin_name" value="{$tplData.adminRow.admin_name}" class="form-control" readonly>
							</div>

							<div class="form-group">
								<div id="group_admin_pass">
									<label class="control-label">{$lang.label.password}{$lang.label.modOnly}</label>
									<input type="text" name="admin_pass" id="admin_pass" class="form-control">
								</div>
							</div>
						{else}
							<div class="form-group">
								<div id="group_admin_name">
									<label class="control-label">{$lang.label.username}<span id="msg_admin_name">*</span></label>
									<input type="text" name="admin_name" id="admin_name" class="validate form-control">
								</div>
							</div>

							<div class="form-group">
								<div id="group_admin_pass">
									<label class="control-label">{$lang.label.password}<span id="msg_admin_pass">*</span></label>
									<input type="text" name="admin_pass" id="admin_pass" class="validate form-control">
								</div>
							</div>
						{/if}

						<div class="form-group">
							<div id="group_admin_nick">
								<label class="control-label">{$lang.label.nick}<span id="msg_admin_nick"></span></label>
								<input type="text" name="admin_nick" id="admin_nick" value="{$tplData.adminRow.admin_nick}" class="validate form-control">
							</div>
						</div>

						<label class="control-label">{$lang.label.allow}<span id="msg_admin_allow">*</span></label>
						<div class="form-group">
							<div class="checkbox_baigo">
								<label for="chk_all">
									<input type="checkbox" id="chk_all" class="first">
									{$lang.label.all}
								</label>
							</div>
							<dl>
								{foreach $adminMod as $key_m=>$value_m}
									<dt>{$value_m.main.title}</dt>
									<dd>
										<label for="allow_{$key_m}" class="checkbox-inline">
											<input type="checkbox" id="allow_{$key_m}" class="chk_all">
											{$lang.label.all}
										</label>
										{foreach $value_m.allow as $key_s=>$value_s}
											<label for="allow_{$key_m}_{$key_s}" class="checkbox-inline">
												<input type="checkbox" name="admin_allow[{$key_m}][{$key_s}]" value="1" id="allow_{$key_m}_{$key_s}" class="allow_{$key_m}" {if $tplData.adminRow.admin_allow[$key_m][$key_s] == 1}checked{/if}>
												{$value_s}
											</label>
										{/foreach}
									</dd>
								{/foreach}
							</dl>
						</div>

						<div class="form-group">
							<div id="group_admin_note">
								<label class="control-label">{$lang.label.note}<span id="msg_admin_note"></span></label>
								<input type="text" name="admin_note" id="admin_note" value="{$tplData.adminRow.admin_note}" class="validate form-control">
							</div>
						</div>

						<div class="form-group">
							<button type="button" class="go_form btn btn-primary">{$lang.btn.save}</button>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="well">
					{if $tplData.adminRow.admin_id > 0}
						<div class="form-group">
							<label class="control-label">{$lang.label.id}</label>
							<p class="form-control-static">{$tplData.adminRow.admin_id}</p>
						</div>
					{/if}

					<label class="control-label">{$lang.label.status}<span id="msg_admin_status">*</span></label>
					<div class="form-group">
						{foreach $status.admin as $key=>$value}
							<label for="admin_status_{$key}" class="radio-inline">
								<input type="radio" name="admin_status" id="admin_status_{$key}" value="{$key}" class="validate" {if $tplData.adminRow.admin_status == $key}checked{/if} group="admin_status">
								{$value}
							</label>
						{/foreach}
					</div>

					<label class="control-label">{$lang.label.profileAllow}</label>
					<div class="form-group">
						<div class="checkbox_baigo">
							<label for="admin_allow_info">
								<input type="checkbox" name="admin_allow[info]" id="admin_allow_info" value="1" {if $tplData.adminRow.admin_allow.info == "1"}checked{/if}>
								{$lang.label.profileInfo}
							</label>
						</div>
						<div class="checkbox_baigo">
							<label for="admin_allow_pass">
								<input type="checkbox" name="admin_allow[pass]" id="admin_allow_pass" value="1" {if $tplData.adminRow.admin_allow.pass == "1"}checked{/if}>
								{$lang.label.profilePass}
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>

{include "include/admin_foot.tpl" cfg=$cfg}

	<script type="text/javascript">
	var opts_validator_form = {
		admin_name: {
			length: { min: 1, max: 30 },
			validate: { type: "ajax", format: "strDigit", group: "group_admin_name" },
			msg: { id: "msg_admin_name", too_short: "{$alert.x020201}", too_long: "{$alert.x020202}", format_err: "{$alert.x020203}" },
			ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=admin&act_get=chkname", key: "admin_name", type: "str", attach: "admin_id={$tplData.adminRow.admin_id}" }
		},
		admin_pass: {
			length: { min: 1, max: 0 },
			validate: { type: "str", format: "text", group: "group_admin_pass" },
			msg: { id: "msg_admin_pass", too_short: "{$alert.x020205}" }
		},
		admin_nick: {
			length: { min: 0, max: 30 },
			validate: { type: "str", format: "text", group: "group_admin_nick" },
			msg: { id: "msg_admin_nick", too_long: "{$alert.x020212}" }
		},
		admin_note: {
			length: { min: 0, max: 30 },
			validate: { type: "str", format: "text", group: "group_admin_note" },
			msg: { id: "msg_admin_note", too_long: "{$alert.x020208}" }
		},
		admin_status: {
			length: { min: 1, max: 0 },
			validate: { type: "radio" },
			msg: { id: "msg_admin_status", too_few: "{$alert.x020209}" }
		}
	};
	var opts_submit_form = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=admin",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	$(document).ready(function(){
		var obj_validator_form = $("#admin_form").baigoValidator(opts_validator_form);
		var obj_submit_form = $("#admin_form").baigoSubmit(opts_submit_form);
		$(".go_form").click(function(){
			if (obj_validator_form.validateSubmit()) {
				obj_submit_form.formSubmit();
			}
		});
		$("#admin_form").baigoCheckall();
	})
	</script>

{include "include/html_foot.tpl" cfg=$cfg}
