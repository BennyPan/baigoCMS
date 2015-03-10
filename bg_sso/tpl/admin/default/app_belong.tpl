{* user_list.tpl 管理员列表 *}
{$cfg = [
	title          => "{$adminMod.app.main.title} - {$lang.page.appBelong}",
	menu_active    => "app",
	sub_active     => "list",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=app&{$tplData.query}"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=app&act_get=list">{$adminMod.app.main.title}</a></li>
	<li>{$lang.page.appBelong}</li>

	{include "include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<ul class="list-inline">
			<li>
				<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=app&act_get=list">
					<span class="glyphicon glyphicon-chevron-left"></span>
					{$lang.href.back}
				</a>
			</li>
			<li>
				<a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=app" target="_blank">
					<span class="glyphicon glyphicon-question-sign"></span>
					{$lang.href.help}
				</a>
			</li>
			<li>
				{$lang.label.appName}: {$tplData.appRow.app_name}
			</li>
		</ul>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="well">
				<label class="control-label">{$lang.label.belongUser}</label>
				<form name="belong_search" id="belong_search" class="form-inline" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get">
					<input type="hidden" name="mod" value="app">
					<input type="hidden" name="act_get" value="belong">
					<input type="hidden" name="app_id" value="{$tplData.appRow.app_id}">
					<div class="form-group">
						<input type="text" name="key_belong" class="form-control input-sm" value="{$tplData.search.key_belong}" placeholder="{$lang.label.key}">
					</div>
					<div class="form-group">
						<button class="btn btn-default btn-sm" type="submit">
							<span class="glyphicon glyphicon-search"></span>
						</button>
					</div>
				</form>
			</div>

			<form name="belong_list" id="belong_list">
				<input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
				<input type="hidden" name="app_id" value="{$tplData.appRow.app_id}">

				<div class="panel panel-default">
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th class="td_mn">
										<label for="belong_all" class="checkbox-inline">
											<input type="checkbox" name="belong_all" id="belong_all" class="first">
											{$lang.label.all}
										</label>
									</th>
									<th class="td_mn">{$lang.label.id}</th>
									<th>{$lang.label.user}</th>
									<th class="td_md">{$lang.label.status} / {$lang.label.note}</th>
								</tr>
							</thead>
							<tbody>
								{foreach $tplData.userViews as $value}
									{if $value.user_status == "enable"}
										{$_css_status = "success"}
									{else if $value.user_status == "wait"}
										{$_css_status = "warning"}
									{else}
										{$_css_status = "danger"}
									{/if}
									<tr>
										<td class="td_mn"><input type="checkbox" name="user_id[]" value="{$value.user_id}" id="user_belong_{$value.user_id}" group="user_id" class="validate belong_all"></td>
										<td class="td_mn">{$value.user_id}</td>
										<td>
											{$value.user_name}
											{if $value.user_nick}[ {$value.user_nick} ]{/if}
										</td>
										<td class="td_md">
											<ul class="list-unstyled">
												<li>
													<span class="label label-{$_css_status}">{$status.user[$value.user_status]}</span>
												</li>
												<li>{$value.user_note}</li>
											</ul>
										</td>
									</tr>
								{/foreach}
							</tbody>
							<tfoot>
								<tr>
									<td colspan="2"><span id="msg_user_belong"></span></td>
									<td colspan="2">
										<input type="hidden" name="act_post" id="act_post" value="deauth">
										<button type="button" id="go_belong" class="btn btn-primary btn-sm">{$lang.btn.deauth}</button>
									</td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>

			</form>
		</div>

		<div class="col-md-6">
			<div class="well">
				<label class="control-label">{$lang.label.selectUser}</label>
				<form name="user_search" id="user_search" class="form-inline" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get">
					<input type="hidden" name="mod" value="app">
					<input type="hidden" name="act_get" value="belong">
					<input type="hidden" name="app_id" value="{$tplData.appRow.app_id}">
					<div class="form-group">
						<input type="text" name="key" class="form-control input-sm" value="{$tplData.search.key}" placeholder="{$lang.label.key}">
					</div>
					<div class="form-group">
						<button class="btn btn-default btn-sm" type="submit">
							<span class="glyphicon glyphicon-search"></span>
						</button>
					</div>
				</form>
			</div>

			<form name="user_list" id="user_list">
				<input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
				<input type="hidden" name="app_id" value="{$tplData.appRow.app_id}">

				<div class="panel panel-default">
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th class="td_mn">
										<label for="user_all" class="checkbox-inline">
											<input type="checkbox" name="user_all" id="user_all" class="first">
											{$lang.label.all}
										</label>
									</th>
									<th class="td_mn">{$lang.label.id}</th>
									<th>{$lang.label.user}</th>
									<th class="td_md">{$lang.label.status} / {$lang.label.note}</th>
								</tr>
							</thead>
							<tbody>
								{foreach $tplData.userRows as $value}
									{if $value.user_status == "enable"}
										{$_css_status = "success"}
									{else if $value.user_status == "wait"}
										{$_css_status = "warning"}
									{else}
										{$_css_status = "danger"}
									{/if}
									<tr>
										<td class="td_mn"><input type="checkbox" name="user_id[]" value="{$value.user_id}" id="user_id_{$value.user_id}" group="user_id" class="validate user_all"></td>
										<td class="td_mn">{$value.user_id}</td>
										<td>
											{$value.user_name}
											{if $value.user_nick}[ {$value.user_nick} ]{/if}
										</td>
										<td class="td_md">
											<ul class="list-unstyled">
												<li>
													<span class="label label-{$_css_status}">{$status.user[$value.user_status]}</span>
												</li>
												<li>{$value.user_note}</li>
											</ul>
										</td>
									</tr>
								{/foreach}
							</tbody>
							<tfoot>
								<tr>
									<td colspan="2"><span id="msg_user_id"></span></td>
									<td colspan="2">
										<input type="hidden" name="act_post" value="auth">
										<button type="button" id="go_list" class="btn btn-primary btn-sm">{$lang.btn.auth}</button>
									</td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>

			</form>

			<div class="text-right">
				{include "include/page.tpl" cfg=$cfg}
			</div>
		</div>
	</div>

{include "include/admin_foot.tpl" cfg=$cfg}

	<script type="text/javascript">
	var opts_validator_belong = {
		user_id: {
			length: { min: 1, max: 0 },
			validate: { type: "checkbox" },
			msg: { id: "msg_user_belong", too_few: "{$alert.x030202}" }
		}
	};

	var opts_submit_belong = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=app",
		confirm_id: "act_post",
		confirm_val: "deauth",
		confirm_msg: "{$lang.confirm.deauth}",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	var opts_validator_list = {
		user_id: {
			length: { min: 1, max: 0 },
			validate: { type: "checkbox" },
			msg: { id: "msg_user_id", too_few: "{$alert.x030202}" }
		}
	};

	var opts_submit_list = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=app",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	$(document).ready(function(){
		var obj_validate_belong = $("#belong_list").baigoValidator(opts_validator_belong);
		var obj_submit_belong = $("#belong_list").baigoSubmit(opts_submit_belong);
		$("#go_belong").click(function(){
			if (obj_validate_belong.validateSubmit()) {
				obj_submit_belong.formSubmit();
			}
		});
		var obj_validate_list = $("#user_list").baigoValidator(opts_validator_list);
		var obj_submit_list = $("#user_list").baigoSubmit(opts_submit_list);
		$("#go_list").click(function(){
			if (obj_validate_list.validateSubmit()) {
				obj_submit_list.formSubmit();
			}
		});
		$("#belong_list").baigoCheckall();
		$("#user_list").baigoCheckall();
	})
	</script>

{include "include/html_foot.tpl" cfg=$cfg}
