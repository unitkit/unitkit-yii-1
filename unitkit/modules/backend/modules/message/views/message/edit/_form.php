<?php
$hasErrors = $models['BMessage']->hasErrors();
if (! $hasErrors)
    foreach ($relatedDatas['i18nIds'] as $i18nId) {
        $hasErrors = $models['bMessageI18ns'][$i18nId]->hasErrors();
        if ($hasErrors)
            break;
    }
?>
<?php if( $hasErrors ) : ?>
<div class="alert alert-danger">
	<?= BHtml::errorSummary(array_merge(array($models['BMessage']), $models['bMessageI18ns'])); ?>
</div>
<?php endif ?>

<?php if($isSaved): ?>
<div class="alert alert-success">
    <h4><?= B::t('unitkit', 'is_saved') ?></h4>
    <div class="action-success">
		<?php if($this->getAction()->getId() == 'create'): ?>
		<a class="btn-success btn btn-add-again" href="<?= $this->createUrl($this->id.'/create'); ?>">
            <span class="glyphicon glyphicon-plus-sign"></span>
            <span><?= B::t('unitkit', 'btn_add_again'); ?></span>
        </a>
        <a class="btn btn-default btn-close" href="<?= $this->createUrl($this->id.'/list'); ?>">
            <span><?= B::t('unitkit', 'btn_close'); ?></span>
        </a>
		<?php else: ?>
		<a class="btn btn-default btn-close" href="<?= $this->createUrl($this->id.'/list'); ?>">
            <span><?= B::t('unitkit', 'btn_close'); ?></span>
        </a>
		<?php endif; ?>
	</div>
</div>
<?php endif ?>

<form method="POST" action="<?=$this->createUrl($this->id.'/'.$action, array('id' => $pk['id'], )); ?>">
    <table class="table table-striped table-condensed">
        <tbody>
            <tr>
                <th><?=$models['BMessage']->getAttributeLabel('b_message_group_id'); ?></th>
                <td class="<?=$models['BMessage']->hasErrors('b_message_group_id') ? 'has-error' : ''; ?>">
            	<?=
            	   BHtml::activeHiddenField(
                        $models['BMessage'],
                        'b_message_group_id',
                        array(
                            'class' => 'input-ajax-select',
                            'id' => uniqid(),
                            'data-action' => $this->createUrl($this->id . '/advCombobox/', array('name' => 'BMessageGroupI18n[name]', 'language' => Yii::app()->language)),
                            'data-placeholder' => B::t('unitkit', 'input_select'),
                            'data-text' => ! empty($models['BMessage']->b_message_group_id) ? BMessageGroupI18n::model()->findByPk(array('b_message_group_id' => $models['BMessage']->b_message_group_id,'i18n_id' => Yii::app()->language))->name : '',
                            'data-addAction' => $this->createUrl('messageGroup/create'),
                            'data-updateAction' => $this->createUrl('messageGroup/update')
                        )
                    );
                ?>
        		</td>
            </tr>
            <!-- BMessage b_message_group_id -->

            <tr>
                <th><?=$models['BMessage']->getAttributeLabel('source'); ?></th>
                <td class="<?=$models['BMessage']->hasErrors('source') ? 'has-error' : ''; ?>">
            	<?=
                    BHtml::activeTextField(
                        $models['BMessage'],
                        'source',
                        array('class' => 'form-control input-sm','placeholder' => $models['BMessage']->getAttributeLabel('source'),'id' => false)
                    );
                ?>
        		</td>
            </tr>
            <!-- BMessage source -->

            <?php foreach($relatedDatas['i18nIds'] as $i18nId): ?>
            <tr>
                <th><?= BHtml::labelI18n($i18nId) ?></th>
                <td class="control-group <?=$models['bMessageI18ns'][$i18nId]->hasErrors('translation') ? 'error' : ''; ?>">
            	<?=
                    BHtml::activeTextArea(
                        $models['bMessageI18ns'][$i18nId],
                        'translation',
                        array(
                            'class' => 'form-control input-sm',
                            'name' => 'bMessageI18ns[' . $i18nId . '][translation]',
                            'placeholder' => $models['bMessageI18ns'][$i18nId]->getAttributeLabel('translation'),
                            'id' => false
                        )
                    );
                ?>
            	</td>
            </tr>
            <?php endforeach ?>

			<!-- BMessageI18n translation -->
            <?php if( ! $models['BMessage']->isNewRecord ): ?>
            <tr>
                <th><?= $models['BMessage']->getAttributeLabel('created_at'); ?></th>
                <td class="control-group">
            		<?= Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($models['BMessage']->created_at, 'yyyy-MM-dd hh:mm:ss')); ?>
            	</td>
            </tr>
            <!-- BMessage created_at -->

            <tr>
                <th><?=$models['BMessage']->getAttributeLabel('updated_at'); ?></th>
                <td class="control-group">
            		<?=Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($models['BMessage']->updated_at, 'yyyy-MM-dd hh:mm:ss')); ?>
            	</td>
            </tr>
            <!-- BMessage updated_at -->
            <?php endif; ?>
    	</tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="text-center">
                    <button class="btn btn-primary btn-update">
                        <span class="glyphicon glyphicon-floppy-disk"></span>
                        <span><?=B::t('unitkit', 'btn_save') ?></span>
                    </button>
                    <a href="<?= $this->createUrl($this->id.'/list'); ?>" class="btn btn-default btn-close">
                        <span><?= B::t('unitkit', 'btn_close') ?></span>
                    </a>
                </td>
            </tr>
        </tfoot>
    </table>
</form>