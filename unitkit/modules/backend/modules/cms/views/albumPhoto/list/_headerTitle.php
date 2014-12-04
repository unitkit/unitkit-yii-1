<h1><?= $dataView->title; ?></h1>
<div class="actions">
	<?php if (Yii::app()->user->checkMultiAccess($this->getDefaultRoles('create'))): ?>
    <a href="<?= $this->createUrl($this->id.'/create', array('album' => $_GET['album'])); ?>" class="btn btn-sm btn-danger btn-add">
        <span class="glyphicon glyphicon-plus-sign"></span>
        <b><?= Unitkit::t('unitkit', 'btn_add'); ?></b>
    </a>
    <?php endif; ?>
    <a href="<?= $this->createUrl('/cms/album/list/', array('page' => isset($_GET['albumPage']) ? $_GET['albumPage'] : 1)); ?>" class="btn btn-default btn-sm btn-dyn-page">
        <span><?= Unitkit::t('backend', 'btn_back_album'); ?></span>
    </a>
   	<a href="#" class="btn btn-default btn-sm btn-adv-search">
        <span class="glyphicon glyphicon-search"></span>
        <span><?= Unitkit::t('unitkit', 'btn_advanced_search'); ?></span>
    </a>
    <a href="<?= $this->createUrl($this->id.'/settings'); ?>" class="btn btn-default btn-sm btn-settings">
        <span class="glyphicon glyphicon-wrench"></span>
        <span><?= Unitkit::t('unitkit', 'btn_settings'); ?></span>
    </a>
    <a href="<?= $this->createUrl($this->id.'/export'); ?>" class="btn btn-default btn-sm btn-export">
        <i class="icon-download-alt"></i>
        <span class="glyphicon glyphicon-download-alt"></span>
        <span><?= Unitkit::t('unitkit', 'btn_export_csv'); ?></span>
    </a>
</div>