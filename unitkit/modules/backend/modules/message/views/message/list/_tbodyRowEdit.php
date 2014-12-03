<tr class="form-inline">
    <td class="form-inline">
	   <?php if(Yii::app()->user->checkMultiAccess($this->getDefaultRoles('delete'))): ?>
    	<div class="form-group">
            <label class="checkbox">
    		    <?=BHtml::checkBox('rows[]', false, array('class' => 'check-row','id' => false,'value' => http_build_query(array('id' => $model['BMessage']->id))));?>
    		</label>
        </div>
	   <?php endif; ?>
    	<div class="form-group">
        	<?php if(Yii::app()->user->checkMultiAccess($this->getDefaultRoles('delete'))): ?>
        	 <a href="<?= $this->createUrl($this->id.'/deleteRows', $_GET); ?>" data-name="rows[]"
                data-value="<?= http_build_query(array('id' => $model['BMessage']->id)); ?>" class="btn-delete-row"
                title="<?= B::t('unitkit', 'btn_delete'); ?>">
                <span class="glyphicon glyphicon-trash"></span>
            </a>
        	<?php endif; ?>
    	</div>
    </td>
    <td class="control-group">
        <?= $model['BMessage']->source; ?>
    </td>
    <td class="control-group <?=$model['BMessage']->hasErrors('b_message_group_id') ? 'error' : ''; ?>">
        <div class="input">
        	<?=
                BHtml::activeHiddenField(
                    $model['BMessage'],
                    'b_message_group_id',
                    array(
                        'class' => 'form-control input-sm input-ajax-select',
                        'name' => 'bMessages[' . $model['BMessage']->id . '][b_message_group_id]',
                        'id' => 'BMessageGroupI18nNameListTbodyRowEdit' . $model['BMessage']->id,
                        'data-action' => $this->createUrl($this->id . '/advComboBox/', array('name' => 'BMessageGroupI18n[name]','language' => Yii::app()->language)),
                        'data-placeholder' => B::t('unitkit', 'input_select'),
                        'data-text' => isset($relatedData['BMessageGroupI18n[name]'][$model['BMessage']->b_message_group_id]) ? $relatedData['BMessageGroupI18n[name]'][$model['BMessage']->b_message_group_id] : '',
                        'data-addAction' => $this->createUrl('messageGroup/create'),
                    )
                );
            ?>
		</div>
		<?php if ($model['BMessage']->hasErrors('b_message_group_id')): ?>
        <div class="help-inline"><?=BHtml::error($model['BMessage'], 'b_message_group_id'); ?></div>
        <?php endif; ?>
    </td>
	<?php foreach($relatedData['i18nIds'] as $i18nId): ?>
	<td class="control-group <?=$model['bMessageI18ns'][$i18nId]->hasErrors('translation') ? 'error' : ''; ?>">
        <div class="input">
        	<?=
                BHtml::activeTextArea(
                    $model['bMessageI18ns'][$i18nId],
                    'translation',
                    array(
                        'class' => 'form-control input-sm',
                        'name' => 'bMessageI18ns[' . $model['BMessage']->id . '][' . $i18nId . '][translation]',
                        'placeholder' => $model['bMessageI18ns'][$i18nId]->getAttributeLabel('translation'),
                        'id' => false
                    )
                );
            ?>
		</div>
		<?php if($model['bMessageI18ns'][$i18nId]->hasErrors('translation')): ?>
        <div class="help-inline"><?=BHtml::error($model['bMessageI18ns'][$i18nId], 'translation'); ?></div>
        <?php endif; ?>
    </td>
	<?php endforeach; ?>
</tr>