<h4><?= Unitkit::t('unitkit', 'is_saved'); ?></h4>
<div class="action-success">
	<?php if($this->getAction()->getId() == 'create' && isset($_REQUEST['addAgain'])): ?>
	<a class="btn-success btn btn-add-again" href="<?= $this->createUrl($this->id.'/create'); ?>">
        <span class="glyphicon glyphicon-plus-sign"></span>
        <span><?= Unitkit::t('unitkit', 'btn_add_again'); ?></span>
    </a>
    <a class="btn btn-default btn-close" href="<?= $dataView->closeAction; ?>">
        <span><?= Unitkit::t('unitkit', 'btn_close'); ?></span>
    </a>
	<?php else: ?>
	<a class="btn btn-default btn-close" href="<?= $dataView->closeAction; ?>">
        <span><?= Unitkit::t('unitkit', 'btn_close'); ?></span>
    </a>
	<?php endif; ?>
    <?php if (isset($_GET['CKEditorFuncNum'])): ?>
    <?php $model = $dataView->items[2]->model; ?>
    <a href="#" class="btn btn-info" onclick="window.opener.CKEDITOR.tools.callFunction(<?= (int) $_GET['CKEditorFuncNum']; ?>, '<?= $model::$upload['file_path']['urlDest'].'/sm/'.$model->file_path; ?>', ''); window.close(); return false;">
        <?= Unitkit::t('backend', 'btn_cms_image_select_sm'); ?>
    </a>
    <a href="#" class="btn btn-info" onclick="window.opener.CKEDITOR.tools.callFunction(<?= (int) $_GET['CKEditorFuncNum']; ?>, '<?= $model::$upload['file_path']['urlDest'].'/lg/'.$model->file_path; ?>', ''); window.close(); return false;">
        <?= Unitkit::t('backend', 'btn_cms_image_select_lg'); ?>
    </a>
    <?php endif; ?>
</div>