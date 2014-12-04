<?php if(Yii::app()->user->checkMultiAccess($this->getDefaultRoles('delete'))): ?>
<tr>
    <td colspan="<?= count($relatedData['i18nIds']) + 3 ?>">
        <a href="#" class="check-all">
            <span class="glyphicon glyphicon-check"></span>
            <span><?= Unitkit::t('unitkit', 'btn_check_all'); ?></span>
        </a>
        <span>|</span>
        <a href="#" class="uncheck-all">
            <span class="glyphicon glyphicon-unchecked"></span>
            <span><?= Unitkit::t('unitkit', 'btn_uncheck_all'); ?></span>
        </a>
        <span class="glyphicon glyphicon-chevron-right"></span>
        <a href="<?=$this->createUrl($this->id.'/deleteRows', $_GET); ?>" class="btn-delete-all">
            <span class="glyphicon glyphicon-trash"></span>
            <span><?= Unitkit::t('unitkit', 'btn_delete_selected'); ?></span>
        </a>
    </td>
</tr>
<?php endif; ?>