<!DOCTYPE html>
<html lang="{$config.lang|truncate:2:''}">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>{$cfg.title} - {$lang.page.admin} - {$smarty.const.BG_SITE_NAME}</title>

    <!--jQuery 库-->
    <script src="{$smarty.const.BG_URL_STATIC}js/jquery.min.js" type="text/javascript"></script>
    <link href="{$smarty.const.BG_URL_STATIC}admin/{$config.ui}/css/admin_common.css" type="text/css" rel="stylesheet">
    <link href="{$smarty.const.BG_URL_STATIC}js/bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet">

    {if isset($cfg.tagmanager)}
        <link rel="stylesheet" href="{$smarty.const.BG_URL_STATIC}js/typeahead/typeahead.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="{$smarty.const.BG_URL_STATIC}js/tagmanager/tagmanager.css" type="text/css" rel="stylesheet">
    {/if}

    {if isset($cfg.upload)}
        <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
        <link href="{$smarty.const.BG_URL_STATIC}js/jQuery-File-Upload/jquery.fileupload.css" type="text/css" rel="stylesheet">
    {/if}

    {if isset($cfg.datepicker)}
        <link href="{$smarty.const.BG_URL_STATIC}js/datetimepicker/jquery.datetimepicker.css" type="text/css" rel="stylesheet">
    {/if}

    {if isset($cfg.baigoValidator)}
        <!--表单验证 js-->
        <link href="{$smarty.const.BG_URL_STATIC}js/baigoValidator/baigoValidator.css" type="text/css" rel="stylesheet">
    {/if}

    {if isset($cfg.baigoSubmit)}
        <!--表单 ajax 提交 js-->
        <link href="{$smarty.const.BG_URL_STATIC}js/baigoSubmit/baigoSubmit.css" type="text/css" rel="stylesheet">
    {/if}
</head>
<body>
