            </div>

            <div class="panel-footer">
                <div class="pull-left">
                    {if $config.ui == "default"}
                        <a href="{$smarty.const.PRD_CMS_URL}" target="_blank">{$smarty.const.PRD_CMS_POWERED} {$smarty.const.PRD_CMS_NAME}</a>
                    {else}
                        <a href="#">{$config.ui} CMS</a>
                    {/if}
                </div>
                <div class="pull-right">
                    <a href="{$smarty.const.BG_URL_HELP}ctl.php?mod={$cfg.mod_help}&act_get={$cfg.act_help}" target="_blank">
                        <span class="glyphicon glyphicon-question-sign"></span>
                        {$lang.href.help}
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
