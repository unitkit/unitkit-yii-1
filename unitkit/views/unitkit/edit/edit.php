<?php
Yii::app()
    ->clientScript
    ->registerDynamicScript(
        'uAppCrudCoreScript',
        Yii::app()->clientScript->getAppCrudMessages()."
        new $.b.app.Edit({
        	main:'#" . $dataView->id . "'
        }).initEvents();"
    );
?>
<div class="edit" id="<?= $dataView->id; ?>">
    <?php $this->bRenderPartial('edit/_content', array('dataView' => $dataView)); ?>
</div>