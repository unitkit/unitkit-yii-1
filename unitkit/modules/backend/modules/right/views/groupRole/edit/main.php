<?php
Yii::app()
    ->clientScript
    ->registerDynamicScript(
        'bRightGroupRoleMain',
        "new $.b.app.Edit({
    		main: '#bRightGroupRoleMain .group-role'
    	}).initEvents();"
    );
?>
<div id="bRightGroupRoleMain">
    <div class="group-role">
	    <?php $this->renderPartial('edit/_edit', array('models' => $models, 'isSaved' => $isSaved)); ?>
	</div>
</div>