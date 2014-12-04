<div class="header-title">
    <h1><?= Unitkit::t('backend', 'message_message_list_title'); ?></h1>
    <div class="actions">
		<?php if( Yii::app()->user->checkMultiAccess($this->getDefaultRoles('create'))): ?>
	    <a href="<?= $this->createUrl($this->id.'/create'); ?>" class="btn btn-sm btn-danger btn-add">
	       <span class="glyphicon glyphicon-plus-sign"></span>
	       <b><?= Unitkit::t('unitkit', 'btn_add'); ?></b>
        </a>
	    <?php endif ?>
	   	<a href="#" class="btn btn-default btn-sm btn-adv-search">
	   	   <span class="glyphicon glyphicon-search"></span>
	   	   <span><?= Unitkit::t('unitkit', 'btn_advanced_search'); ?></span>
        </a>
        <a href="<?=$this->createUrl($this->id.'/settings'); ?>" class="btn btn-default btn-sm btn-settings">
            <span class="glyphicon glyphicon-wrench"></span>
            <span><?= Unitkit::t('unitkit', 'btn_settings'); ?></span>
        </a>
    </div>
</div>

<div class="inner-container">
    <div class="adv-search">
    <?php
        $this->renderPartial('list/_search', array(
            'model' => $model,
            'relatedData' => $relatedData
        ));
    ?>
	</div>
    <div class="grid">
    <?php
        $this->renderPartial('list/_table', array(
            'pagination' => $pagination,
            'models' => $models,
            'sort' => $sort,
            'model' => $model,
            'relatedData' => $relatedData,
            'isSaved' => $isSaved
        ));
    ?>
	</div>
</div>