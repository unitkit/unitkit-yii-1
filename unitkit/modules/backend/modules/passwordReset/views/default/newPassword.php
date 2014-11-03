<div class="row">
    <div class="col-md-6">
        <div class="header-title">
            <h1><?= B::t('backend', 'password_reset_title'); ?></h1>
        </div>
        <div class="inner-container">
        <?php if( ! isset($models['NewPasswordForm'])): ?>
            <div class="alert alert-info">
        		<?= $message; ?>
        	</div>
        <?php else: ?>
            <?php if($models['NewPasswordForm']->hasErrors()): ?>
        	<div class="alert alert-danger">
        		<?= BHtml::errorSummary($models['NewPasswordForm']); ?>
        	</div>
        	<?php endif; ?>
            <form method="POST" class="csrf" action="<?= $this->createUrl($this->id.'/validate', array('code' => $_GET['code'], 'uuid' => $_GET['uuid'])); ?>">
                <div class="form-group <?= $models['NewPasswordForm']->hasErrors('password') ? 'error' : ''; ?>">
                    <label><?= $models['NewPasswordForm']->getAttributeLabel('password'); ?></label>
                    <?= BHtml::activePasswordField($models['NewPasswordForm'], 'password', array('class' => 'form-control input-sm')); ?>
                </div>
                <div class="form-group <?= $models['NewPasswordForm']->hasErrors('repeat_password') ? 'has-error' : ''; ?>">
                    <label><?= $models['NewPasswordForm']->getAttributeLabel('repeat_password'); ?></label>
                    <?=BHtml::activePasswordField($models['NewPasswordForm'], 'repeat_password', array('class' => 'form-control input-sm'));?>
                </div>
                <?=BHtml::button(B::t('unitkit', 'btn_save'), array('type' => 'submit','class' => 'btn btn-primary'));?>
            </form>
        <?php endif; ?>
        </div>
    </div>
</div>