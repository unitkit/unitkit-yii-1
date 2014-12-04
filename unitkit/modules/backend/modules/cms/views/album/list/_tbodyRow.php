<div class="col-xs-6 col-md-3">
    <div class="thumbnail">
       <div class="caption"><h4><?= $dataView->items[0]; ?></h4></div>
       <div class="option">
            <a href="<?= $this->createUrl('/cms/albumPhoto/list/', array('album' => $dataView->pk['id'], 'albumPage' => $pagination->currentPage + 1)); ?>" class="btn btn-sm btn-default btn-dyn-page"
                title="<?= Unitkit::t('backend', 'btn_view_photos'); ?>">
                <span class="glyphicon glyphicon-camera"></span>
            </a>
            <?php if( Yii::app()->user->checkMultiAccess($this->getDefaultRoles('update'))): ?>
            <a href="<?= $this->createUrl($this->id.'/update', $dataView->pk); ?>" class="btn btn-sm btn-default btn-update"
                title="<?= Unitkit::t('unitkit', 'btn_update'); ?>">
                <span class="glyphicon glyphicon-pencil"></span>
            </a>
            <?php endif; ?>

           <?php if($dataView->isTranslatable && Yii::app()->user->checkMultiAccess($this->getDefaultRoles('update'))): ?>
            <a href="<?= $this->createUrl($this->id.'/translate', $dataView->pk); ?>" class="btn btn-sm btn-default btn-translate"
                title="<?= Unitkit::t('unitkit', 'btn_translate'); ?>">
                <span class="glyphicon glyphicon-globe"></span>
            </a>
            <?php endif; ?>

            <?php if( Yii::app()->user->checkMultiAccess($this->getDefaultRoles('delete'))): ?>
			<a href="<?= $this->createUrl($this->id.'/deleteRows', $_GET); ?>" data-name="rows[]"
                data-value="<?=http_build_query($dataView->pk); ?>" class="btn btn-sm btn-default btn-delete-row"
                title="<?= Unitkit::t('unitkit', 'btn_delete'); ?>">
                <span class="glyphicon glyphicon-trash"></span>
            </a>
			<?php endif ?>
       </div>
    </div>
</div>