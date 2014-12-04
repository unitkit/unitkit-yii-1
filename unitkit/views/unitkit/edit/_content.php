<div class="header-title">
    <a href="<?= $dataView->closeAction; ?>" class="close btn-close">&times;</a>
    <h1><?= $dataView->isNewRecord ? $dataView->createTitle : $dataView->updateTitle; ?></h1>
</div>
<div class="inner-container">
	<?php $this->bRenderPartial('edit/_form', array('dataView' => $dataView)); ?>
</div>