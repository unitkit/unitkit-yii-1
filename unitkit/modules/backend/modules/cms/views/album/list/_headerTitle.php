<h1><?= $dataView->title; ?></h1>
<div class="actions">
   	<a href="#" class="btn btn-default btn-sm btn-adv-search">
        <span class="glyphicon glyphicon-search"></span>
        <span><?= Unitkit::t('unitkit', 'btn_advanced_search'); ?></span>
    </a>
    <a href="<?= $this->createUrl($this->id.'/export'); ?>" class="btn btn-default btn-sm btn-export">
        <i class="icon-download-alt"></i>
        <span class="glyphicon glyphicon-download-alt"></span>
        <span><?= Unitkit::t('unitkit', 'btn_export_csv'); ?></span>
    </a>
</div>