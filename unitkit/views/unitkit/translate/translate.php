<?php
Yii::app()
    ->clientScript
    ->registerDynamicScript(
        'uAppCrudCoreScript',
        Yii::app()->clientScript->getAppCrudMessages()."
        new $.unitkit.app.Translate({
        	main:'#" . $dataView->id . "'
        }).initEvents();"
    );
?>
<div class="translate" id="<?= $dataView->id; ?>">
    <div class="header-title">
        <a href="<?= $dataView->closeAction; ?>" class="close btn-close">&times;</a>
        <h1><?= $dataView->title; ?></h1>
    </div>
    <div class="inner-container">
		<?php $this->bRenderPartial('translate/_form', array('dataView' => $dataView)); ?>
	</div>
</div>