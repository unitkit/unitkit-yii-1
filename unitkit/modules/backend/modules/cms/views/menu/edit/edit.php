<?php
Yii::app()->clientScript
    ->registerScriptFile('/modules/cms/js/jquery.backend.cms.menu.js')
    ->registerScript(
        'bCoreScript',
        Yii::app()->clientScript->getAppCrudMessages() . "
        new $.backend.cms.menu.Edit({
        	main:'#" . $dataView->id . "'
        }).initEvents();"
    );
?>
<div class="edit" id="<?= $dataView->id; ?>">
    <?php $this->bRenderPartial('edit/_content', array('dataView' => $dataView)); ?>
</div>