<?php
Yii::app()->clientScript
    ->registerScriptFile('/modules/cms/js/jquery.backend.cms.pageContainer.js')
    ->registerScript(
        'bAppCrudCoreScript',
        Yii::app()->clientScript->getAppCrudMessages()."
        new $.backend.cms.pageContainer.Translate({
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