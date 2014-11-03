<?php if( Yii::app()->user->checkMultiAccess($this->getDefaultRoles('update'))): ?>
<a href="<?= $this->createUrl($this->id.'/update', array('album' => $_GET['album']) + $dataView->pk); ?>" class="btn btn-sm btn-default btn-update"
    title="<?= B::t('unitkit', 'btn_update'); ?>">
    <span class="glyphicon glyphicon-pencil"></span>
</a>
<?php endif; ?>

<?php if($dataView->isTranslatable && Yii::app()->user->checkMultiAccess($this->getDefaultRoles('update'))): ?>
<a href="<?= $this->createUrl($this->id.'/translate', array('album' => $_GET['album']) + $dataView->pk); ?>" class="btn btn-sm btn-default btn-translate"
    title="<?= B::t('unitkit', 'btn_translate'); ?>">
    <span class="glyphicon glyphicon-globe"></span>
</a>
<?php endif; ?>