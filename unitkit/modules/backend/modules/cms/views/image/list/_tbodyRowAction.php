<?php if( Yii::app()->user->checkMultiAccess($this->getDefaultRoles('update'))): ?>
<a href="<?= $this->createUrl($this->id.'/update', $dataView->pk); ?>" class="btn btn-sm btn-default btn-update"
    title="<?= B::t('unitkit', 'btn_update'); ?>">
    <span class="glyphicon glyphicon-pencil"></span>
</a><br />
<?php endif; ?>

<?php if($dataView->isTranslatable && Yii::app()->user->checkMultiAccess($this->getDefaultRoles('update'))): ?>
<a href="<?= $this->createUrl($this->id.'/translate', $dataView->pk); ?>" class="btn btn-sm btn-default btn-translate"
    title="<?= B::t('unitkit', 'btn_translate'); ?>">
    <span class="glyphicon glyphicon-globe"></span>
</a><br />
<?php endif; ?>

<?php if (isset($_GET['CKEditorFuncNum'])): ?>
<?php $model = $dataView->data; ?>
<a href="#" class="btn btn-sm btn-info" onclick="window.opener.CKEDITOR.tools.callFunction(<?= (int) $_GET['CKEditorFuncNum']; ?>, '<?= $model::$upload['file_path']['urlDest'].'/sm/'.$model->file_path; ?>', ''); window.close(); return false;">
    <?= B::t('backend', 'btn_cms_image_select_sm'); ?>
</a><br />
<a href="#" class="btn btn-sm btn-info" onclick="window.opener.CKEDITOR.tools.callFunction(<?= (int) $_GET['CKEditorFuncNum']; ?>, '<?= $model::$upload['file_path']['urlDest'].'/lg/'.$model->file_path; ?>', ''); window.close(); return false;">
    <?= B::t('backend', 'btn_cms_image_select_lg'); ?>
</a>
<?php endif; ?>