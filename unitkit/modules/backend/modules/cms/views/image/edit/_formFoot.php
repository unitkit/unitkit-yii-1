<tr>
    <td colspan="2" class="text-center">
        <button class="btn btn-primary btn-update">
            <span class="glyphicon glyphicon-floppy-disk"></span>
            <span><?= B::t('unitkit', 'btn_save'); ?></span>
        </button>
        <a href="<?= $dataView->closeAction; ?>" class="btn btn-default btn-close">
            <span><?= B::t('unitkit', 'btn_close'); ?></span>
        </a>
        <?php if (isset($_GET['CKEditorFuncNum']) && ! $dataView->isNewRecord): ?>
        <?php $model = $dataView->items[2]->model; ?>
        <a href="#" class="btn btn-info" onclick="window.opener.CKEDITOR.tools.callFunction(<?= (int) $_GET['CKEditorFuncNum']; ?>, '<?= $model::$upload['file_path']['urlDest'].'/sm/'.$model->file_path; ?>', ''); window.close(); return false;">
            <?= B::t('backend', 'btn_cms_image_select_sm'); ?>
        </a>
        <a href="#" class="btn btn-info" onclick="window.opener.CKEDITOR.tools.callFunction(<?= (int) $_GET['CKEditorFuncNum']; ?>, '<?= $model::$upload['file_path']['urlDest'].'/lg/'.$model->file_path; ?>', ''); window.close(); return false;">
            <?= B::t('backend', 'btn_cms_image_select_lg'); ?>
        </a>
        <?php endif; ?>
    </td>
</tr>