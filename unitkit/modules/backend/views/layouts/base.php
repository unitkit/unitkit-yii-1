<?php
Yii::app()
    ->clientScript
    ->registerScript(
        'bAppInit',
        "$.b.application = new $.b.app.Backend();
         $.b.application.initEvents();",
        CClientScript::POS_READY
    );
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?= CHtml::encode($this->pageTitle); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="<?= Yii::app()->request->csrfTokenName ?>" content="<?= Yii::app()->request->getCsrfToken(); ?>" />
</head>
<body>
    <?= $content; ?>
    <div id="b"></div>
</body>
</html>