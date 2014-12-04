<?php
    $count = count($dataView->rows);
    $maxFirstLine = 4;
    if (Yii::app()->user->checkMultiAccess($this->getDefaultRoles('create'))) {
        $maxFirstLine = $count > 3 ? 3 : $count;
    }
?>
<div class="row">
    <?php if (Yii::app()->user->checkMultiAccess($this->getDefaultRoles('create'))): ?>
    <div class="col-xs-6 col-md-3">
        <div class="thumbnail">
            <div class="option-add option">
                <a href="<?= $this->createUrl($this->id.'/create'); ?>" class="btn btn-danger btn-add">
                    <span class="glyphicon glyphicon-plus-sign"></span>
                    <b><?= Unitkit::t('unitkit', 'btn_add'); ?></b>
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if($dataView->pagination->itemCount > 0) : ?>
        <?php for($i = 0; $i < $maxFirstLine; ++$i): ?>
            <?php $this->bRenderPartial('list/_tbodyRow', array('dataView' => $dataView->rows[$i], 'pagination' => $dataView->pagination)); ?>
        <?php endfor; ?>
    <?php endif; ?>
</div>

<?php if($dataView->pagination->itemCount > 0) : ?>
    <?php for($i = $maxFirstLine, $j = 1; $i < $count; ++$i, ++$j): ?>
        <?php if ($j % 4 == 1 || $i == $maxFirstLine): ?>
        <div class="row">
        <?php endif; ?>
        <?php $this->bRenderPartial('list/_tbodyRow', array('dataView' => $dataView->rows[$i], 'pagination' => $dataView->pagination)); ?>
        <?php if ( ($j % 4 == 0 && $j != 0) || $i == $count - 1): ?>
        </div>
        <?php endif; ?>
    <?php endfor; ?>
<?php endif; ?>

<?php $this->bRenderPartial('list/_pager', array('dataView' => $dataView)); ?>