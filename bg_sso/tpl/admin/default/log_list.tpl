{* log_list.tpl 管理员列表 *}
{$cfg = [
	title          => $adminMod.log.main.title,
	menu_active    => "log",
	sub_active     => "list",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=log&{$tplData.query}"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<li>{$adminMod.log.main.title}</li>

	{include "include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<div class="pull-left">
			<a href="{$smarty.const.BG_URL_HELP}?lang=zh_CN&mod=help&act=log" target="_blank">
				<span class="glyphicon glyphicon-question-sign"></span>
				{$lang.href.help}
			</a>
		</div>
		<div class="pull-right">
			<form name="log_search" id="log_search" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get" class="form-inline">
				<input type="hidden" name="mod" value="log">
				<input type="hidden" name="act_get" value="list">
				<select name="type" class="form-control input-sm">
					<option value="">{$lang.option.allType}</option>
					{foreach $type.log as $key=>$value}
						<option {if $tplData.search.type == $key}selected{/if} value="{$key}">{$value}</option>
					{/foreach}
				</select>
				<select name="status" class="form-control input-sm">
					<option value="">{$lang.option.allStatus}</option>
					{foreach $status.log as $key=>$value}
						<option {if $tplData.search.status == $key}selected{/if} value="{$key}">{$value}</option>
					{/foreach}
				</select>
				<input type="text" name="key" value="{$tplData.search.key}" placeholder="{$lang.label.key}" class="form-control input-sm">
				<button type="submit" class="btn btn-default btn-sm">{$lang.btn.filter}</button>
			</form>
		</div>
		<div class="clearfix"></div>
	</div>

	<form name="log_list" id="log_list" class="form-inline">
		<input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">

		<div class="panel panel-default">
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th class="td_mn">
								<label for="chk_all" class="checkbox-inline">
									<input type="checkbox" name="chk_all" id="chk_all" class="first">
									{$lang.label.all}
								</label>
							</th>
							<th class="td_mn">{$lang.label.id}</th>
							<th>{$lang.label.title}</th>
							<th>{$lang.label.content}</th>
							<th class="td_bg">{$lang.label.operator}</th>
							<th class="td_sm">{$lang.label.status} / {$lang.label.type}</th>
						</tr>
					</thead>
					<tbody>
						{foreach $tplData.logRows as $value}
							{if $value.log_status == "read"}
								{$_css_status = "default"}
							{else}
								{$_css_status = "warning"}
							{/if}
							<tr>
								<td class="td_mn"><input type="checkbox" name="log_id[]" value="{$value.log_id}" id="log_id_{$value.log_id}" group="log_id" class="validate chk_all"></td>
								<td class="td_mn">{$value.log_id}</td>
								<td>
									<div>
										{$value.log_title}
									</div>
									<div>
										<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=log&act_get=show&log_id={$value.log_id}&view=iframe" data-toggle="modal" data-target="#log_modal">{$lang.href.show}</a>
									</div>
								</td>
								<td>
									{$value.log_content}
								</td>
								<td class="td_bg">
									<div>
										{if $value.log_type != "system"}
											<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=log&act_get=log&operator_id={$value.log_operator_id}">{$value.log_operator_name}</a>
										{else}
											{$type.log[$value.log_type]}
										{/if}
									</div>
									<div>{$value.log_operator_name|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIME}"}</div>
								</td>
								<td class="td_sm">
									<div>
										<span class="label label-{$_css_status}">{$status.log[$value.log_status]}</span>
									</div>
									<div>{$type.log[$value.log_type]}</div>
								</td>
							</tr>
						{/foreach}
					</tbody>
					<tfoot>
						<tr>
							<td colspan="2"><span id="msg_log_id"></span></td>
							<td colspan="5">
								<select name="act_post" id="act_post" class="validate form-control input-sm">
									<option value="">{$lang.option.batch}</option>
									{foreach $status.log as $key=>$value}
										<option value="{$key}">{$value}</option>
									{/foreach}
									<option value="del">{$lang.option.del}</option>
								</select>
								<button type="button" id="go_list" class="btn btn-sm btn-primary">{$lang.btn.submit}</button>
								<span id="msg_act_post"></span>
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

	<div class="modal fade" id="log_modal">
		<div class="modal-dialog">
			<div class="modal-content"></div>
		</div>
	</div>

{include "include/admin_foot.tpl" cfg=$cfg}

	<script type="text/javascript">
	var opts_validator_list = {
		log_id: {
			length: { min: 1, max: 0 },
			validate: { type: "checkbox" },
			msg: { id: "msg_log_id", too_few: "{$alert.x030202}" }
		},
		act_post: {
			length: { min: 1, max: 0 },
			validate: { type: "select" },
			msg: { id: "msg_act_post", too_few: "{$alert.x030203}" }
		}
	};
	var opts_submit_list = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=log",
		confirm_id: "act_post",
		confirm_val: "del",
		confirm_msg: "{$lang.confirm.del}",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	$(document).ready(function(){
		$("#log_modal").on("hidden.bs.modal", function() {
		    $(this).removeData("bs.modal");
		});
		var obj_validator_form    = $("#log_list").baigoValidator(opts_validator_list);
		var obj_submit_form       = $("#log_list").baigoSubmit(opts_submit_list);
		$("#go_list").click(function(){
			if (obj_validator_form.validateSubmit()) {
				obj_submit_form.formSubmit();
			}
		});
		$("#log_list").baigoCheckall();
	})
	</script>

{include "include/html_foot.tpl" cfg=$cfg}
