<?php if($isSaved): ?>
<div class="alert alert-success">
    <h4><?= Unitkit::t('unitkit', 'is_saved') ?></h4>
</div>
<?php endif ?>

<div class="table-responsive">
    <table class="table table-hover table-condensed">
        <thead>
        <?php
            $this->renderPartial('list/_thead', array(
                'sort' => $sort,
                'model' => $model,
                'relatedData' => $relatedData
            ));
        ?>
        </thead>
        <tbody>
            <?php if($pagination->itemCount > 0): ?>
                <?php foreach($models as $model): ?>
                    <?php $this->renderPartial('list/_tbodyRowEdit', array('model' => $model, 'relatedData' => $relatedData)); ?>
                <?php endforeach; ?>
            <?php else : ?>
            <tr>
                <td colspan="<?= count($relatedData['i18nIds']) + 3; ?>" class="text-center">
                    <em><?= Unitkit::t('unitkit', 'no_results'); ?></em>
                </td>
            </tr>
            <?php endif;  ?>
        </tbody>
        <tfoot>
            <?php $this->renderPartial('list/_tfoot', array('relatedData' => $relatedData)); ?>
        </tfoot>
    </table>
</div>

<div class="text-center">
    <a href="<?= $this->createUrl($this->id.'/list', $_GET); ?>" class="btn btn-danger btn-translate-all" title="<?= Unitkit::t('unitkit', 'btn_translate'); ?>">
        <span class="glyphicon glyphicon-globe"></span>
        <span><?= Unitkit::t('backend', 'btn_translate_all_message'); ?></span>
    </a>
</div>

<?php $this->renderPartial('list/_pager', array('pagination' => $pagination)); ?>

