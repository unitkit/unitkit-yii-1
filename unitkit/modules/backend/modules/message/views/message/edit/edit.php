<?php
Yii::app()
    ->clientScript
    ->registerScript(
        'uMessageMessageEdit',
        Yii::app()->clientScript->getAppCrudMessages()."
    	new $.b.app.Edit({
    		main: '#uMessageMessageEdit'
    	}).initEvents();"
    );
?>
<div class="edit" id="uMessageMessageEdit">
<?php
    $this->renderPartial('edit/' . $tpl, array(
        'models' => $models,
        'relatedData' => $relatedData,
        'isSaved' => $isSaved,
        'pk' => $pk
    ));
?>
</div>