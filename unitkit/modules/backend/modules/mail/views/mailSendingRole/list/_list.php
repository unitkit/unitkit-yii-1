<div class="header-title">
    <h1><?= $dataView->title; ?></h1>
    <div class="actions">
		<?php if(Yii::app()->user->checkMultiAccess($this->defaultRoles['create'])): ?>
	    <a href="<?=$this->createUrl($this->id.'/create', array('UMailSendingRole[u_mail_template_id]' => $_GET['UMailSendingRole']['u_mail_template_id'])); ?>"
            class="btn btn-sm btn-danger btn-add"> <span class="glyphicon glyphicon-plus-sign"></span> <b><?= Unitkit::t('unitkit', 'btn_add'); ?></b>
        </a>
	    <?php endif ?>
		<a class="btn btn-default btn-sm btn-close" href="#"> <span><?= Unitkit::t('unitkit', 'btn_close'); ?></span>
        </a>
    </div>
</div>

<div class="inner-container">
    <div class="grid table-condensed">
		<?php $this->bRenderPartial('list/_table', array('dataView' => $dataView)); ?>
	</div>
</div>