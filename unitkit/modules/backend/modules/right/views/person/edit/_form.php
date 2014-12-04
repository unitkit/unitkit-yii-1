<?php if($dataView->data['UPerson']->hasErrors()) : ?>
<div class="alert alert-danger">
	<?= UHtml::errorSummary($dataView->data['UPerson']); ?>
</div>
<?php endif ?>

<?php if($dataView->isSaved): ?>
<div class="alert alert-success">
    <h4><?= Unitkit::t('unitkit', 'is_saved'); ?></h4>
    <div class="action-success">
    <?php if($this->getAction()->getId() == 'create'): ?>
        <a class="btn-success btn btn-add-again" href="<?=$this->createUrl($this->id.'/create'); ?>">
            <span class="glyphicon glyphicon-plus-sign"></span>
            <span><?= Unitkit::t('unitkit', 'btn_add_again'); ?></span>
        </a>
        <a class="btn btn-default btn-close" href="<?= $dataView->closeAction; ?>">
            <span><?= Unitkit::t('unitkit', 'btn_close'); ?></span>
        </a>
	<?php else: ?>
        <a class="btn btn-default btn-close" href="<?= $dataView->closeAction; ?>">
            <span><?= Unitkit::t('unitkit', 'btn_close'); ?></span>
        </a>
	<?php endif; ?>
	</div>
</div>
<?php endif; ?>

<form method="POST" action="<?=$this->createUrl($this->id.'/'.($dataView->isNewRecord ? 'create' : 'update'), $dataView->pk); ?>">
    <table class="table table-striped table-condensed">
        <tbody>
            <tr>
                <th><?=$dataView->data['UPerson']->getAttributeLabel('email'); ?></th>
                <td class="<?=$dataView->data['UPerson']->hasErrors('email') ? 'has-error' : ''; ?>">
                    <?= UHtml::activeTextField($dataView->data['UPerson'], 'email', array('class' => 'form-control input-sm', 'placeholder' => $dataView->data['UPerson']->getAttributeLabel('email'),'id' => false)); ?>
        		</td>
            </tr>
            <tr>
                <th><?=$dataView->data['UPerson']->getAttributeLabel('password'); ?></th>
                <td class="<?=$dataView->data['UPerson']->hasErrors('password') ? 'has-error' : ''; ?>">
                    <?=UHtml::activeTextField($dataView->data['UPerson'], 'password', array('class' => 'form-control input-sm', 'placeholder' => $dataView->data['UPerson']->getAttributeLabel('password'),'id' => false)); ?>
        		</td>
            </tr>
            <tr>
                <th><?=$dataView->data['UPerson']->getAttributeLabel('first_name'); ?></th>
                <td class="<?=$dataView->data['UPerson']->hasErrors('first_name') ? 'has-error' : ''; ?>">
                    <?=UHtml::activeTextField($dataView->data['UPerson'], 'first_name', array('class' => 'form-control input-sm select-related-field', 'placeholder' => $dataView->data['UPerson']->getAttributeLabel('first_name'),'id' => false)); ?>
        		</td>
            </tr>
            <tr>
                <th><?=$dataView->data['UPerson']->getAttributeLabel('last_name'); ?></th>
                <td class="<?=$dataView->data['UPerson']->hasErrors('last_name') ? 'has-error' : ''; ?>">
                    <?=UHtml::activeTextField($dataView->data['UPerson'], 'last_name', array('class' => 'form-control input-sm', 'placeholder' => $dataView->data['UPerson']->getAttributeLabel('last_name'), 'id' => false)); ?>
        		</td>
            </tr>
            <tr>
                <th><?=$dataView->data['UPerson']->getAttributeLabel('activated'); ?></th>
                <td class="<?=$dataView->data['UPerson']->hasErrors('activated') ? 'has-error' : ''; ?>">
                    <?=UHtml::activeCheckBox($dataView->data['UPerson'], 'activated', array('class' => 'form-control input-sm', 'placeholder' => $dataView->data['UPerson']->getAttributeLabel('activated'), 'id' => false)); ?>
        		</td>
            </tr>
            <tr>
                <th><?=$dataView->data['UPerson']->getAttributeLabel('validated'); ?></th>
                <td class="<?=$dataView->data['UPerson']->hasErrors('validated') ? 'has-error' : ''; ?>">
                    <?=UHtml::activeCheckBox($dataView->data['UPerson'], 'validated', array('class' => 'form-control', 'placeholder' => $dataView->data['UPerson']->getAttributeLabel('validated'), 'id' => false)); ?>
        		</td>
            </tr>
            <tr>
                <th><?=$dataView->data['UPerson']->getAttributeLabel('active_reset'); ?></th>
                <td class="<?=$dataView->data['UPerson']->hasErrors('active_reset') ? 'has-error' : ''; ?>">
                    <?=UHtml::activeCheckBox($dataView->data['UPerson'], 'active_reset', array('class' => 'form-control', 'placeholder' => $dataView->data['UPerson']->getAttributeLabel('active_reset'), 'id' => false)); ?>
        		</td>
            </tr>
            <tr>
                <th><?=$dataView->data['UPerson']->getAttributeLabel('default_language'); ?></th>
                <td class="<?=$dataView->data['UPerson']->hasErrors('default_language') ? 'has-error' : ''; ?>">
                    <?=
                        UHtml::activeHiddenField(
                            $dataView->data['UPerson'],
                            'default_language',
                            array(
                                'class' => 'form-control input-sm input-ajax-select',
                                'id' => false,
                                'data-action' => $this->createUrl($this->id . '/advComboBox/', array('name' => 'UI18nI18n[name]','language' => Yii::app()->language)),
                                'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                                'data-text' => ! empty($dataView->data['UPerson']->default_language) ? UI18nI18n::model()->findByPk(array('u_i18n_id' => $dataView->data['UPerson']->default_language,'i18n_id' => Yii::app()->language))->name : ''
                            )
                        );
                    ?>
        		</td>
            </tr>

            <?php if(Yii::app()->user->checkAccess('administrate:backend/right')): ?>
            <tr>
                <th><?=Unitkit::t('unitkit','u_person:u_groups') ?></th>
                <td class="control-group form-inline">
            		<?php foreach($dataView->data['UGroups'] as $UGroup): ?>
                        <label class="checkbox" for="<?=get_class($dataView->data['UPersonGroups'][$UGroup->id]).'s['.$UGroup->id.']'; ?>">
                            <?=$UGroup->uGroupI18ns[0]->name; ?>
                            <?=UHtml::hiddenField(get_class($dataView->data['UPersonGroups'][$UGroup->id]).'s['.$UGroup->id.']', 0); ?>
                            <?=UHtml::checkBox(get_class($dataView->data['UPersonGroups'][$UGroup->id]) . 's[' . $UGroup->id . ']', $dataView->data['UPersonGroups'][$UGroup->id]->u_group_id == $UGroup->id, array('id' => get_class($dataView->data['UPersonGroups'][$UGroup->id]) . 's[' . $UGroup->id . ']')); ?>
          			    </label>
            		<?php endforeach ?>
            	</td>
            </tr>
			<?php endif ?>

            <?php if( ! $dataView->data['UPerson']->isNewRecord ): ?>
            <tr>
                <th><?=$dataView->data['UPerson']->getAttributeLabel('created_at') ?></th>
                <td class="control-group">
            		<?=Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($dataView->data['UPerson']->created_at, 'yyyy-MM-dd hh:mm:ss'))?>
            	</td>
            </tr>
            <tr>
                <th><?=$dataView->data['UPerson']->getAttributeLabel('updated_at') ?></th>
                <td class="control-group">
            		<?=Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($dataView->data['UPerson']->updated_at, 'yyyy-MM-dd hh:mm:ss'))?>
            	</td>
            </tr>
            <?php endif ?>
    	</tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="text-center">
                    <a href="#" class="btn btn-primary btn-update">
                        <span class="glyphicon glyphicon-floppy-disk"></span>
                        <span><?=Unitkit::t('unitkit', 'btn_save') ?></span>
                    </a>
                    <a href="<?= $dataView->closeAction; ?>" class="btn btn-default btn-close">
                        <span><?= Unitkit::t('unitkit', 'btn_close') ?></span>
                    </a>
                </td>
            </tr>
        </tfoot>
    </table>
</form>