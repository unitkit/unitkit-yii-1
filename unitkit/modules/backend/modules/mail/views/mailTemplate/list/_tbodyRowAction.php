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

<?php if(Yii::app()->user->checkMultiAccess($this->getDefaultRoles('update'))): ?>
<a href="<?=$this->createUrl('mailSendingRole/list', array('UMailSendingRole[u_mail_template_id]' => $dataView->pk['id'])) ?>"
    class="btn btn-sm btn-default btn-list-sending-role">
    <span><?=Unitkit::t('backend', 'mail_template_btn_list_role')?></span>
</a>
<?php endif; ?>