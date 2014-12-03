<?php if($dataView->isSaved): ?>
<div class="alert alert-success">
    <h4><?= B::t('unitkit', 'is_saved'); ?></h4>
    <div class="action-success">
        <a class="btn btn-default btn-close" href="<?= $dataView->closeAction; ?>">
            <span><?= B::t('unitkit', 'btn_close'); ?></span>
        </a>
    </div>
</div>
<?php endif; ?>

<form method="POST" action="<?= $dataView->action; ?>">
    <div class="table-responsive">
        <table class="table table-condensed">
            <thead>
                <tr class="form-inline">
                    <th><i class="icon-th-list"></i></th>
                    <?php foreach($dataView->relatedData['i18nIds'] as $i18nId): ?>
                    <th><?= BHtml::labelI18n($i18nId); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php $this->bRenderPartial('translate/_tbody', array('dataView' => $dataView)); ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="<?= count($dataView->relatedData['i18nIds']) + 2; ?>" class="text-center">
                        <button class="btn btn-primary btn-update">
                            <span class="glyphicon glyphicon-floppy-disk"></span>
                            <span><?= B::t('unitkit', 'btn_save'); ?></span>
                        </button>
                        <a href="<?= $dataView->closeAction; ?>" class="btn btn-default btn-close">
                            <span><?= B::t('unitkit', 'btn_close'); ?></span>
                        </a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</form>