<?php
Yii::app()
    ->clientScript
    ->registerScript(
        'uAppInit',
        "$.unitkit.application = new $.unitkit.app.Frontend();
         $.unitkit.application.initEvents();",
        CClientScript::POS_READY
    );
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <title><?= UHtml::encode($this->pageTitle); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Custom CSS -->
    <link href="/css/business-casual.css" rel="stylesheet">
    <!-- Fonts -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <meta name="<?= Yii::app()->request->csrfTokenName ?>" content="<?= Yii::app()->request->getCsrfToken(); ?>" />
</head>
<body>
    <?php $this->widget('application.modules.frontend.widgets.menu.UWidgetCmsMenu', array('id' => Unitkit::v('frontend', 'u_cms_menu_group_id:main'))); ?>
    <div class="container">
    <?= $content; ?>
    </div>
    <!-- /.container -->

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p><?= Unitkit::v('frontend', 'website_name') ?> &copy; <?= date('Y'); ?> - Powered by - Powered by <a href="http://www.unitkit.com" target="_blank">UNITKIT</a></p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>