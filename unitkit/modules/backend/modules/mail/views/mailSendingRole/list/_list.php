<div class="header-title">
    <h1><?= $dataView->title; ?></h1>
    <div class="actions">
		<?php if(Yii::app()->user->checkMultiAccess($this->defaultRoles['create'])): ?>
	    <a
            href="<?=$this->createUrl($this->id.'/create', array('BMailSendingRole[b_mail_template_id]' => $_GET['BMailSendingRole']['b_mail_template_id'])); ?>"
            class="btn btn-sm btn-danger btn-add"> <span class="glyphicon glyphicon-plus-sign"></span> <b><?= B::t('unitkit', 'btn_add'); ?></b>
        </a>
	    <?php endif ?>
		<a class="btn btn-default btn-sm btn-close" href="#"> <span><?= B::t('unitkit', 'btn_close'); ?></span>
        </a>
    </div>
    <!-- actions -->
</div>

<div class="inner-container">
    <div class="grid">
		<?php $this->bRenderPartial('list/_table', array('dataView' => $dataView)); ?>
	</div>
    <!-- grid container -->
</div>