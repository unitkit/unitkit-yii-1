<?php
Yii::app()
    ->clientScript
    ->registerDynamicCssFile('/modules/cms/css/backend.cms.album.css')
    ->registerAppCrudViewCoreScripts(
        array(
            'list',
            'edit',
            'translate'
        ),
        '#' . $dataView->id
    );
?>
<div id="<?= $dataView->id; ?>">
    <div class="dynamic"></div>
    <div class="list">
		<?= $this->bRenderPartial('list/_list', array('dataView' => $dataView), true); ?>
	</div>
</div>