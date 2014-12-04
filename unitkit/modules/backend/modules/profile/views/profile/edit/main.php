<?php
Yii::app()
    ->clientScript
    ->registerDynamicScript(
        'uProfileProfilMain',
        Yii::app()->clientScript->getAppCrudMessages() . "
    	var edit = new $.unitkit.app.Edit({
    		main: '#uProfileProfileMain .inner-container'
    	});
    	edit.initEvents();"
    );
?>
<div id="uProfileProfileMain">
    <div class="header-title">
        <h1><?= Unitkit::t('backend', 'profile_edit_title') ?></h1>
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