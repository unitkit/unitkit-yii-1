<?php
Yii::app()
    ->clientScript
    ->registerDynamicScript(
        'bProfileProfilMain',
        Yii::app()->clientScript->getAppCrudMessages() . "
    	var edit = new $.b.app.Edit({
    		main: '#bProfileProfilMain .inner-container'
    	});
    	edit.initEvents();"
    );
?>
<div id="bProfilProfileMain">
    <div class="header-title">
        <h1><?= B::t('backend', 'profile_edit_title') ?></h1>
    </div>
    <div class="inner-container">
    <?php
        $this->renderPartial('edit/_form', array(
            'models' => $models,
            'relatedDatas' => $relatedDatas,
            'isSaved' => $isSaved
        ));
    ?>
    </div>
</div>