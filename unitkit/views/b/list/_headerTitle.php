<h1><?= $dataView->title; ?></h1>
<div class="actions">
	<?php if (Yii::app()->user->checkMultiAccess($this->getDefaultRoles('create'))): ?>
    <a href="<?= $this->createUrl($this->id.'/create'); ?>" class="btn btn-sm btn-danger btn-add">
        <span class="glyphicon glyphicon-plus-sign"></span>
        <b><?= B::t('unitkit', 'btn_add'); ?></b>
    </a>
    <?php endif; ?>
   	<a href="#" class="btn btn-default btn-sm btn-adv-search">
        <span class="glyphicon glyphicon-search"></span>
        <span><?= B::t('unitkit', 'btn_advanced_search'); ?></span>
    </a>
    <a href="<?= $this->createUrl($this->id.'/settings'); ?>" class="btn btn-default btn-sm btn-settings">
        <span class="glyphicon glyphicon-wrench"></span>
        <span><?= B::t('unitkit', 'btn_settings'); ?></span>
    </a>
    <a href="<?= $this->createUrl($this->id.'/export'); ?>" class="btn btn-default btn-sm btn-export">
        <i class="icon-download-alt"></i>
        <span class="glyphicon glyphicon-download-alt"></span>
        <span><?= B::t('unitkit', 'btn_export_csv'); ?></span>
    </a>
</div>