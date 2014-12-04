<h4><?= Unitkit::t('unitkit', 'is_saved'); ?></h4>
<div class="action-success">
	<?php if($this->getAction()->getId() == 'create'): ?>
	<a class="btn-success btn btn-dyn-page" href="<?= $this->createUrl('/cms/albumPhoto/create/', array('album' => $dataView->pk['id'])); ?>">
        <span class="glyphicon glyphicon-plus-sign"></span>
        <span><?= Unitkit::t('backend', 'btn_add_cms_album_photo'); ?></span>
    </a>
    <a class="btn btn-default btn-close" href="<?= $dataView->closeAction; ?>">
        <span><?= Unitkit::t('unitkit', 'btn_close'); ?></span>
    </a>
	<?php else: ?>
	<a class="btn btn-default btn-close" href="<?= $dataView->closeAction; ?>">
        <span><?= Unitkit::t('unitkit', 'btn_close'); ?></span>
    </a>
	<?php endif; ?>
</div>