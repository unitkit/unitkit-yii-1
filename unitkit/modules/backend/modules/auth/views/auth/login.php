<?php
Yii::app()
    ->clientScript
    ->registerDynamicCssFile('/modules/auth/css/backend.auth.css');
?>
<div id="uAuthAuthMain" class="container-small">
    <h2><?= Unitkit::t('backend', 'login_title'); ?></h2>

	<?php if($models['LoginForm']->hasErrors()) : ?>
	<div class="alert alert-danger">
		<?= UHtml::errorSummary($models['LoginForm']); ?>
	</div>
	<?php endif; ?>

    <form method="POST" class="csrf" action="<?= $this->createUrl($this->id.'/login'); ?>">
        <table>
            <tr>
                <th><?= $models['LoginForm']->getAttributeLabel('username'); ?></th>
                <td>
        			<?= UHtml::activeTextField($models['LoginForm'], 'username', array('class' => 'form-control input-sm')); ?>
        		</td>
            </tr>
            <tr>
                <th><?= $models['LoginForm']->getAttributeLabel('password'); ?></th>
                <td>
        			<?= UHtml::activePasswordField($models['LoginForm'], 'password', array('class' => 'form-control input-sm')); ?>
        		</td>
            </tr>
            <tr>
                <th><?= $models['LoginForm']->getAttributeLabel('remember_me'); ?></th>
                <td><?= UHtml::activeCheckBox($models['LoginForm'], 'remember_me'); ?></td>
            </tr>
            <tr>
                <th></th>
                <td>
        			<?= UHtml::button(Unitkit::t('unitkit', 'login_btn_connect'), array('type' => 'submit','class' => 'btn btn-primary')); ?>
                    <div class="reset-password">
                        <?= UHtml::link(Unitkit::t('backend', 'password_reset_renew'), $this->createUrl('/passwordReset'), array('class' => 'btn-dyn-page')); ?>
        			</div>
                </td>
            </tr>
        </table>
    </form>
</div>