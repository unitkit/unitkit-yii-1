<?php
Yii::app()
    ->clientScript
    ->registerScript(
        'bMessageMessageEdit',
        Yii::app()->clientScript->getAppCrudMessages()."
    	new $.b.app.Edit({
    		main: '#bMessageMessageEdit'
    	}).initEvents();"
    );
?>
<div class="edit" id="bMessageMessageEdit">
<?php
    $this->renderPartial('edit/' . $tpl, array(
        'models' => $models,
        'relatedDatas' => $relatedDatas,
        'isSaved' => $isSaved,
        'pk' => $pk
    ));
?>
</div>