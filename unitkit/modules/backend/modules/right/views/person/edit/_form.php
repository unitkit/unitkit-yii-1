<?php if($dataView->datas['BPerson']->hasErrors()) : ?>
<div class="alert alert-danger">
	<?= BHtml::errorSummary($dataView->datas['BPerson']); ?>
</div>
<?php endif ?>

<?php if($dataView->isSaved): ?>
<div class="alert alert-success">
    <h4><?= B::t('unitkit', 'is_saved'); ?></h4>
    <div class="action-success">
    <?php if($this->getAction()->getId() == 'create'): ?>
        <a class="btn-success btn btn-add-again" href="<?=$this->createUrl($this->id.'/create'); ?>">
            <span class="glyphicon glyphicon-plus-sign"></span>
            <span><?= B::t('unitkit', 'btn_add_again'); ?></span>
        </a>
        <a class="btn btn-default btn-close" href="<?= $dataView->closeAction; ?>">
            <span><?= B::t('unitkit', 'btn_close'); ?></span>
        </a>
	<?php else: ?>
        <a class="btn btn-default btn-close" href="<?= $dataView->closeAction; ?>">
            <span><?= B::t('unitkit', 'btn_close'); ?></span>
        </a>
	<?php endif; ?>
	</div>
</div>
<?php endif; ?>

<form method="POST" action="<?=$this->createUrl($this->id.'/'.($dataView->isNewRecord ? 'create' : 'update'), $dataView->pk); ?>">
    <table class="table table-striped table-condensed">
        <tbody>
            <tr>
                <th><?=$dataView->datas['BPerson']->getAttributeLabel('email'); ?></th>
                <td class="<?=$dataView->datas['BPerson']->hasErrors('email') ? 'has-error' : ''; ?>">
                    <?= BHtml::activeTextField($dataView->datas['BPerson'], 'email', array('class' => 'form-control input-sm', 'placeholder' => $dataView->datas['BPerson']->getAttributeLabel('email'),'id' => false)); ?>
        		</td>
            </tr>
            <tr>
                <th><?=$dataView->datas['BPerson']->getAttributeLabel('password'); ?></th>
                <td class="<?=$dataView->datas['BPerson']->hasErrors('password') ? 'has-error' : ''; ?>">
                    <?=BHtml::activeTextField($dataView->datas['BPerson'], 'password', array('class' => 'form-control input-sm', 'placeholder' => $dataView->datas['BPerson']->getAttributeLabel('password'),'id' => false)); ?>
        		</td>
            </tr>
            <tr>
                <th><?=$dataView->datas['BPerson']->getAttributeLabel('first_name'); ?></th>
                <td class="<?=$dataView->datas['BPerson']->hasErrors('first_name') ? 'has-error' : ''; ?>">
                    <?=BHtml::activeTextField($dataView->datas['BPerson'], 'first_name', array('class' => 'form-control input-sm select-related-field', 'placeholder' => $dataView->datas['BPerson']->getAttributeLabel('first_name'),'id' => false)); ?>
        		</td>
            </tr>
            <tr>
                <th><?=$dataView->datas['BPerson']->getAttributeLabel('last_name'); ?></th>
                <td class="<?=$dataView->datas['BPerson']->hasErrors('last_name') ? 'has-error' : ''; ?>">
                    <?=BHtml::activeTextField($dataView->datas['BPerson'], 'last_name', array('class' => 'form-control input-sm', 'placeholder' => $dataView->datas['BPerson']->getAttributeLabel('last_name'), 'id' => false)); ?>
        		</td>
            </tr>
            <tr>
                <th><?=$dataView->datas['BPerson']->getAttributeLabel('activated'); ?></th>
                <td class="<?=$dataView->datas['BPerson']->hasErrors('activated') ? 'has-error' : ''; ?>">
                    <?=BHtml::activeCheckBox($dataView->datas['BPerson'], 'activated', array('class' => 'form-control input-sm', 'placeholder' => $dataView->datas['BPerson']->getAttributeLabel('activated'), 'id' => false)); ?>
        		</td>
            </tr>
            <tr>
                <th><?=$dataView->datas['BPerson']->getAttributeLabel('validated'); ?></th>
                <td class="<?=$dataView->datas['BPerson']->hasErrors('validated') ? 'has-error' : ''; ?>">
                    <?=BHtml::activeCheckBox($dataView->datas['BPerson'], 'validated', array('class' => 'form-control', 'placeholder' => $dataView->datas['BPerson']->getAttributeLabel('validated'), 'id' => false)); ?>
        		</td>
            </tr>
            <tr>
                <th><?=$dataView->datas['BPerson']->getAttributeLabel('active_reset'); ?></th>
                <td class="<?=$dataView->datas['BPerson']->hasErrors('active_reset') ? 'has-error' : ''; ?>">
                    <?=BHtml::activeCheckBox($dataView->datas['BPerson'], 'active_reset', array('class' => 'form-control', 'placeholder' => $dataView->datas['BPerson']->getAttributeLabel('active_reset'), 'id' => false)); ?>
        		</td>
            </tr>
            <tr>
                <th><?=$dataView->datas['BPerson']->getAttributeLabel('default_language'); ?></th>
                <td class="<?=$dataView->datas['BPerson']->hasErrors('default_language') ? 'has-error' : ''; ?>">
                    <?=
                        BHtml::activeHiddenField(
                            $dataView->datas['BPerson'],
                            'default_language',
                            array(
                                'class' => 'form-control input-sm input-ajax-select',
                                'id' => false,
                                'data-action' => $this->createUrl($this->id . '/advCombobox/', array('name' => 'BI18nI18n[name]','language' => Yii::app()->language)),
                                'data-placeholder' => B::t('unitkit', 'input_select'),
                                'data-text' => ! empty($dataView->datas['BPerson']->default_language) ? BI18nI18n::model()->findByPk(array('b_i18n_id' => $dataView->datas['BPerson']->default_language,'i18n_id' => Yii::app()->language))->name : ''
                            )
                        );
                    ?>
        		</td>
            </tr>

            <?php if(Yii::app()->user->checkAccess('administrate:backend/right')): ?>
            <tr>
                <th><?=B::t('unitkit','b_person:b_groups') ?></th>
                <td class="control-group form-inline">
            		<?php foreach($dataView->datas['BGroups'] as $BGroup): ?>
                        <label class="checkbox" for="<?=get_class($dataView->datas['BPersonGroups'][$BGroup->id]).'s['.$BGroup->id.']'; ?>">
                            <?=$BGroup->bGroupI18ns[0]->name; ?>
                            <?=BHtml::hiddenField(get_class($dataView->datas['BPersonGroups'][$BGroup->id]).'s['.$BGroup->id.']', 0); ?>
                            <?=BHtml::checkBox(get_class($dataView->datas['BPersonGroups'][$BGroup->id]) . 's[' . $BGroup->id . ']', $dataView->datas['BPersonGroups'][$BGroup->id]->b_group_id == $BGroup->id, array('id' => get_class($dataView->datas['BPersonGroups'][$BGroup->id]) . 's[' . $BGroup->id . ']')); ?>
          			    </label>
            		<?php endforeach ?>
            	</td>
            </tr>
			<?php endif ?>

            <?php if( ! $dataView->datas['BPerson']->isNewRecord ): ?>
            <tr>
                <th><?=$dataView->datas['BPerson']->getAttributeLabel('created_at') ?></th>
                <td class="control-group">
            		<?=Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($dataView->datas['BPerson']->created_at, 'yyyy-MM-dd hh:mm:ss'))?>
            	</td>
            </tr>
            <tr>
                <th><?=$dataView->datas['BPerson']->getAttributeLabel('updated_at') ?></th>
                <td class="control-group">
            		<?=Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($dataView->datas['BPerson']->updated_at, 'yyyy-MM-dd hh:mm:ss'))?>
            	</td>
            </tr>
            <?php endif ?>
    	</tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="text-center">
                    <a href="#" class="btn btn-primary btn-update">
                        <span class="glyphicon glyphicon-floppy-disk"></span>
                        <span><?=B::t('unitkit', 'btn_save') ?></span>
                    </a>
                    <a href="<?= $dataView->closeAction; ?>" class="btn btn-default btn-close">
                        <span><?= B::t('unitkit', 'btn_close') ?></span>
                    </a>
                </td>
            </tr>
        </tfoot>
    </table>
</form>