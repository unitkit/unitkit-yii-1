<h4><?= B::t('unitkit', 'is_saved'); ?></h4>
<div class="action-success">
	<?php if($this->getAction()->getId() == 'create' && isset($_REQUEST['addAgain'])): ?>
	<a class="btn-success btn btn-add-again" href="<?= $this->createUrl($this->id.'/create', array('album' => $_GET['album'])); ?>">
        <span class="glyphicon glyphicon-plus-sign"></span>
        <span><?= B::t('unitkit', 'btn_add_again'); ?></span>
    </a>
    <a class="btn btn-default btn-close" href="<?= $dataView->closeAction; ?>">
        <span><?= B::t('unitkit', 'btn_close'); ?></span>
    </a>
	<?php else: ?>
	<a class="btn btn-default btn-close" href="<?= $dataView->closeAction; ?>">
        <span><?= B::t('unitkit', 'btn_close'); ?></span>
    </a>
	<?php endif; ?>
</div>