<div id="passwordResetMain">
    <div class="col-md-6">
        <div class="header-title">
            <h1><?= Unitkit::t('backend', 'password_reset_title'); ?></h1>
        </div>
        <div class="inner-container">
        <?php if($models['PasswordResetForm']->hasErrors()) : ?>
        	<div class="alert alert-danger">
        		<?= UHtml::errorSummary($models['PasswordResetForm']); ?>
        	</div>
    	<?php endif; ?>

    	<?php if($models['PasswordResetForm']->isSent): ?>
        	<div class="alert alert-success">
                <h4><?= Unitkit::t('backend', 'password_reset_email_sent'); ?></h4>
            </div>
    	<?php else: ?>
            <form role="role" method="POST" class="ajax" data-ajaxTarget="#passwordResetMain" action="<?= $this->createUrl($this->id.'/reset'); ?>">
                <div class="form-group<?= $models['PasswordResetForm']->hasErrors('email') ? ' has-error' : ''; ?>">
                    <label><?= $models['PasswordResetForm']->getAttributeLabel('email'); ?></label>
                    <?=UHtml::activeTextField($models['PasswordResetForm'], 'email', array('class' => 'form-control input-sm'));?>
                </div>
                <?=UHtml::button(Unitkit::t('unitkit', 'btn_send'), array('type' => 'submit','class' => 'btn btn-primary'));?>
            </form>
        <?php endif; ?>
        </div>
    </div>
</div>