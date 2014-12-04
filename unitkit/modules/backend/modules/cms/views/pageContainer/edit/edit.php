<?php
Yii::app()->clientScript
    ->registerScriptFile('/modules/cms/js/jquery.backend.cms.pageContainer.js')
    ->registerScript(
        'uCoreScript',
        Yii::app()->clientScript->getAppCrudMessages() . "
        new $.backend.cms.pageContainer.Edit({
        	main:'#" . $dataView->id . "'
        }).initEvents();"
    );
?>
<div class="edit" id="<?= $dataView->id; ?>">
    <?php $this->bRenderPartial('edit/_content', array('dataView' => $dataView)); ?>
</div>