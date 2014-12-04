<?php
$hasErrors = $models['UMessage']->hasErrors();
if (! $hasErrors)
    foreach ($relatedData['i18nIds'] as $i18nId) {
        $hasErrors = $models['uMessageI18ns'][$i18nId]->hasErrors();
        if ($hasErrors)
            break;
    }
?>
<?php if( $hasErrors ) : ?>
<div class="alert alert-danger">
	<?= UHtml::errorSummary(array_merge(array($models['UMessage']), $models['uMessageI18ns'])); ?>
</div>
<?php endif ?>

<?php if($isSaved): ?>
<div class="alert alert-success">
    <h4><?= Unitkit::t('unitkit', 'is_saved') ?></h4>
    <div class="action-success">
		<?php if($this->getAction()->getId() == 'create'): ?>
		<a class="btn-success btn btn-add-again" href="<?= $this->createUrl($this->id.'/create'); ?>">
            <span class="glyphicon glyphicon-plus-sign"></span>
            <span><?= Unitkit::t('unitkit', 'btn_add_again'); ?></span>
        </a>
        <a class="btn btn-default btn-close" href="<?= $this->createUrl($this->id.'/list'); ?>">
            <span><?= Unitkit::t('unitkit', 'btn_close'); ?></span>
        </a>
		<?php else: ?>
		<a class="btn btn-default btn-close" href="<?= $this->createUrl($this->id.'/list'); ?>">
            <span><?= Unitkit::t('unitkit', 'btn_close'); ?></span>
        </a>
		<?php endif; ?>
	</div>
</div>
<?php endif ?>

<form method="POST" action="<?=$this->createUrl($this->id.'/'.$action, array('id' => $pk['id'], )); ?>">
    <table class="table table-striped table-condensed">
        <tbody>
            <tr>
                <th><?=$models['UMessage']->getAttributeLabel('u_message_group_id'); ?></th>
                <td class="<?=$models['UMessage']->hasErrors('u_message_group_id') ? 'has-error' : ''; ?>">
            	<?=
            	   UHtml::activeHiddenField(
                        $models['UMessage'],
                        'u_message_group_id',
                        array(
                            'class' => 'input-ajax-select',
                            'id' => uniqid(),
                            'data-action' => $this->createUrl($this->id . '/advComboBox/', array('name' => 'UMessageGroupI18n[name]', 'language' => Yii::app()->language)),
                            'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                            'data-text' => ! empty($models['UMessage']->u_message_group_id) ? UMessageGroupI18n::model()->findByPk(array('u_message_group_id' => $models['UMessage']->u_message_group_id,'i18n_id' => Yii::app()->language))->name : '',
                            'data-addAction' => $this->createUrl('messageGroup/create'),
                            'data-updateAction' => $this->createUrl('messageGroup/update')
                        )
                    );
                ?>
        		</td>
            </tr>
            <!-- UMessage u_message_group_id -->

            <tr>
                <th><?=$models['UMessage']->getAttributeLabel('source'); ?></th>
                <td class="<?=$models['UMessage']->hasErrors('source') ? 'has-error' : ''; ?>">
            	<?=
                    UHtml::activeTextField(
                        $models['UMessage'],
                        'source',
                        array('class' => 'form-control input-sm','placeholder' => $models['UMessage']->getAttributeLabel('source'),'id' => false)
                    );
                ?>
        		</td>
            </tr>
            <!-- UMessage source -->

            <?php foreach($relatedData['i18nIds'] as $i18nId): ?>
            <tr>
                <th><?= UHtml::labelI18n($i18nId) ?></th>
                <td class="control-group <?=$models['uMessageI18ns'][$i18nId]->hasErrors('translation') ? 'error' : ''; ?>">
            	<?=
                    UHtml::activeTextArea(
                        $models['uMessageI18ns'][$i18nId],
                        'translation',
                        array(
                            'class' => 'form-control input-sm',
                            'name' => 'uMessageI18ns[' . $i18nId . '][translation]',
                            'placeholder' => $models['uMessageI18ns'][$i18nId]->getAttributeLabel('translation'),
                            'id' => false
                        )
                    );
                ?>
            	</td>
            </tr>
            <?php endforeach ?>

			<!-- UMessageI18n translation -->
            <?php if( ! $models['UMessage']->isNewRecord ): ?>
            <tr>
                <th><?= $models['UMessage']->getAttributeLabel('created_at'); ?></th>
                <td class="control-group">
            		<?= Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($models['UMessage']->created_at, 'yyyy-MM-dd hh:mm:ss')); ?>
            	</td>
            </tr>
            <!-- UMessage created_at -->

            <tr>
                <th><?=$models['UMessage']->getAttributeLabel('updated_at'); ?></th>
                <td class="control-group">
            		<?=Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($models['UMessage']->updated_at, 'yyyy-MM-dd hh:mm:ss')); ?>
            	</td>
            </tr>
            <!-- UMessage updated_at -->
            <?php endif; ?>
    	</tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="text-center">
                    <button class="btn btn-primary btn-update">
                        <span class="glyphicon glyphicon-floppy-disk"></span>
                        <span><?=Unitkit::t('unitkit', 'btn_save') ?></span>
                    </button>
                    <a href="<?= $this->createUrl($this->id.'/list'); ?>" class="btn btn-default btn-close">
                        <span><?= Unitkit::t('unitkit', 'btn_close') ?></span>
                    </a>
                </td>
            </tr>
        </tfoot>
    </table>
</form>