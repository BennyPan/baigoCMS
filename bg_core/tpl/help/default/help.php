<?php header("Content-Type: text/html; charset=utf-8"); ?>
<!DOCTYPE html>
<html lang="<?php echo substr($this->config["lang"], 0, 2); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?php echo $this->tplData["helpConfig"]["title"]; ?></title>

    <!--jQuery 库-->
    <script src="<?php echo BG_URL_STATIC; ?>lib/jquery.min.js" type="text/javascript"></script>

    <!--bootstrap-->
    <link href="<?php echo BG_URL_STATIC; ?>lib/bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="<?php echo BG_URL_STATIC; ?>lib/prism/prism.css" type="text/css" rel="stylesheet">
    <link href="<?php echo BG_URL_STATIC; ?>help/<?php echo BG_DEFAULT_UI; ?>/css/help.css" type="text/css" rel="stylesheet">
</head>

<body>

    <header class="navbar navbar-inverse navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="./">
                    <img alt="baigo CMS" src="<?php echo BG_URL_STATIC; ?>console/<?php echo BG_DEFAULT_UI; ?>/image/logo.png">
                </a>
            </div>
            <nav class="collapse navbar-collapse bs-navbar-collapse">
                <?php if (isset($this->tplData["helpConfig"]["menu"])) { ?>
                    <ul class="nav navbar-nav navbar-right">
                        <?php foreach ($this->tplData["helpConfig"]["menu"] as $key=>$value) {
                            if (isset($value["sub"])) { ?>
                                <li class="dropdown<?php if (isset($this->tplData["config"]["active"]) && $this->tplData["config"]["active"] == $key) { ?> active<?php } ?>">
                                    <a href="<?php echo BG_URL_HELP; ?>index.php?mod=<?php echo $key; ?>" class="dropdown-toggle" data-toggle="dropdown">
                                        <?php if (isset($value["title"])) {
                                            echo $value["title"];
                                        } ?>
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php foreach ($value["sub"] as $key_sub=>$value_sub) { ?>
                                            <li<?php if ($this->tplData["mod"] == $key_sub) { ?> class="active"<?php } ?>>
                                                <a href="<?php echo BG_URL_HELP; ?>index.php?mod=<?php echo $key_sub; ?>"><?php echo $value_sub; ?></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php } else { ?>
                                <li<?php if (isset($this->tplData["config"]["active"]) && $this->tplData["config"]["active"] == $key) { ?> class="active"<?php } ?>>
                                    <a href="<?php echo BG_URL_HELP; ?>index.php?mod=<?php echo $key; ?>">
                                        <?php if (isset($value["title"])) {
                                            echo $value["title"];
                                        } ?>
                                    </a>
                                </li>
                            <?php }
                        } ?>
                    </ul>
                <?php } ?>
            </nav>
        </div>
    </header>


    <div class="container">
        <h2 class="page-header">
            <?php if (isset($this->tplData["config"]["title"])) {
                echo $this->tplData["config"]["title"];
            } ?>
        </h2>
        <div class="row">
            <div class="col-md-10">
                <a name="top"></a>
                <?php echo $this->tplData["content"];

                if ($this->tplData["mod"] == "api" && $GLOBALS["act"] == "rcode") { ?>
                    <div class="panel panel-default">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap"><?php echo $this->lang["label"]["rcode"]; ?></th>
                                        <th><?php echo $this->lang["label"]["description"]; ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($this->rcode as $key=>$value) { ?>
                                        <tr>
                                            <td><?php echo $key; ?></td>
                                            <td><?php echo $value; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>
                <div>&nbsp;</div>
                <div class="text-right">
                    <a href="#top">
                        <span class="glyphicon glyphicon-chevron-up"></span>
                        top
                    </a>
                </div>
            </div>
            <div class="col-md-2">
                <?php if (isset($this->tplData["config"]["menu"])) { ?>
                    <ul class="nav nav-pills nav-stacked">
                        <?php foreach ($this->tplData["config"]["menu"] as $key=>$value) { ?>
                            <li<?php if ($this->tplData["act"] == $key) { ?> class="active"<?php } ?>><a href="<?php echo BG_URL_HELP; ?>index.php?mod=<?php echo $this->tplData["mod"]; ?>&act=<?php echo $key; ?>"><?php echo $value; ?></a></li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </div>

    <footer class="container">
        <hr>
        <ul class="list-inline">
            <?php if (BG_DEFAULT_UI == "default") { ?>
                <li><a href="http://www.baigo.net/" target="_blank">baigo Studio</a></li>
                <li><a href="http://www.baigo.net/cms/" target="_blank">baigo CMS</a></li>
                <li><a href="http://www.baigo.net/sso/" target="_blank">baigo SSO</a></li>
                <li><a href="http://www.baigo.net/ads/" target="_blank">baigo ADS</a></li>
            <?php } else { ?>
                <li><?php echo BG_DEFAULT_UI; ?> CMS</li>
            <?php } ?>
        </ul>
    </footer>

    <!--bootstrap-->
    <script src="<?php echo BG_URL_STATIC; ?>lib/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo BG_URL_STATIC; ?>lib/prism/prism.min.js" type="text/javascript"></script>

    <!--
    <?php echo PRD_CMS_POWERED; ?>
    <?php if (BG_DEFAULT_UI == "default") {
        echo PRD_CMS_NAME;
    } else {
        echo BG_DEFAULT_UI . " CMS";
    } ?>
    <?php echo PRD_CMS_VER; ?>
    -->

</body>
</html>
