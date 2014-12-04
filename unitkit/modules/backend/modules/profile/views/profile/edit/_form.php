<?php if( $models['PersonProfile']->hasErrors()) : ?>
<div class="alert alert-danger">
	<?= UHtml::errorSummary($models['PersonProfile'])?>
</div>
<?php endif ?>

<?php if($isSaved): ?>
<div class="alert alert-success">
    <h4><?= Unitkit::t('unitkit', 'is_saved') ?></h4>
</div>
<?php endif ?>

<form method="POST" action="<?=$this->createUrl($this->id.'/update') ?>">
    <table class="table table-condensed">
        <tbody>
            <tr>
                <th><?=$models['PersonProfile']->getAttributeLabel('first_name') ?></th>
                <td class="<?=$models['PersonProfile']->hasErrors('first_name') ? 'has-error' : '' ?>">
                    <?=UHtml::activeTextField($models['PersonProfile'], 'first_name', array('class' => 'form-control input-sm','placeholder' => $models['PersonProfile']->getAttributeLabel('first_name'), 'id' => false)); ?>
                    <?=UHtml::activeHiddenField($models['PersonProfile'], 'activated', array('value' => 1)); ?>
        		</td>
            </tr>
            <tr>
                <th><?=$models['PersonProfile']->getAttributeLabel('last_name') ?></th>
                <td class="<?=$models['PersonProfile']->hasErrors('last_name') ? 'has-error' : '' ?>">
                    <?=UHtml::activeTextField($models['PersonProfile'], 'last_name', array('class' => 'form-control input-sm','placeholder' => $models['PersonProfile']->getAttributeLabel('last_name'),'id' => false)); ?>
        		</td>
            </tr>
            <tr>
                <th><?=$models['PersonProfile']->getAttributeLabel('email') ?></th>
                <td class="<?=$models['PersonProfile']->hasErrors('email') ? 'has-error' : '' ?>">
                    <?=UHtml::activeTextField($models['PersonProfile'], 'email', array('class' => 'form-control input-sm','placeholder' => $models['PersonProfile']->getAttributeLabel('email'),'id' => false)); ?>
        		</td>
            </tr>
            <tr>
                <th><?=$models['PersonProfile']->getAttributeLabel('default_language') ?></th>
                <td class="<?=$models['PersonProfile']->hasErrors('default_language') ? 'has-error' : '' ?>">
                    <?=
                        UHtml::activeHiddenField(
                            $models['PersonProfile'],
                            'default_language',
                            array(
                                'class' => 'form-control input-sm input-ajax-select',
                                'id' => false,
                                'data-action' => $this->createUrl($this->id . '/advComboBox/', array('name' => 'UI18nI18n[name]','language' => Yii::app()->language)),
                                'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                                'data-text' => ! empty($models['PersonProfile']->default_language) ? UI18nI18n::model()->findByPk(array('u_i18n_id' => $models['PersonProfile']->default_language,'i18n_id' => Yii::app()->language))->name : ''
                            )
                        );
                    ?>
        		</td>
            </tr>
            <tr>
                <th><?=$models['PersonProfile']->getAttributeLabel('old_password'); ?></th>
                <td class="<?=$models['PersonProfile']->hasErrors('old_password') ? 'has-error' : ''; ?>">
                    <?=UHtml::activePasswordField($models['PersonProfile'], 'old_password', array('class' => 'form-control input-sm ','placeholder' => $models['PersonProfile']->getAttributeLabel('old_password'), 'id' => false)); ?>
        		</td>
            </tr>
            <tr>
                <th><?=$models['PersonProfile']->getAttributeLabel('password') ?></th>
                <td class="<?=$models['PersonProfile']->hasErrors('password') ? 'has-error' : '' ?>">
            	<?=UHtml::activePasswordField($models['PersonProfile'], 'password', array('class' => 'form-control input-sm ', 'placeholder' => $models['PersonProfile']->getAttributeLabel('password'), 'id' => false)); ?>
        		</td>
            </tr>
            <tr>
                <th><?=$models['PersonProfile']->getAttributeLabel('repeat_password') ?></th>
                <td class="<?=$models['PersonProfile']->hasErrors('repeat_password') ? 'has-error' : '' ?>">
            	<?=UHtml::activePasswordField($models['PersonProfile'], 'repeat_password', array('class' => 'form-control input-sm ', 'placeholder' => $models['PersonProfile']->getAttributeLabel('repeat_password'), 'id' => false)); ?>
        		</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="text-center">
                    <a class="btn btn-primary btn-update">
                        <span class="glyphicon glyphicon-floppy-disk"></span>
                        <span><?= Unitkit::t('unitkit', 'btn_save'); ?></span>
                    </a>
                </td>
            </tr>
        </tfoot>
    </table>
</form>