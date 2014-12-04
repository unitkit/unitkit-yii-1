<?php
Yii::app()
    ->clientScript
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