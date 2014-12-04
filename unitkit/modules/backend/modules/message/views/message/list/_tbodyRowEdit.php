<tr class="form-inline">
    <td class="form-inline">
	   <?php if(Yii::app()->user->checkMultiAccess($this->getDefaultRoles('delete'))): ?>
    	<div class="form-group">
            <label class="checkbox">
    		    <?=UHtml::checkBox('rows[]', false, array('class' => 'check-row','id' => false,'value' => http_build_query(array('id' => $model['UMessage']->id))));?>
    		</label>
        </div>
	   <?php endif; ?>
    	<div class="form-group">
        	<?php if(Yii::app()->user->checkMultiAccess($this->getDefaultRoles('delete'))): ?>
        	 <a href="<?= $this->createUrl($this->id.'/deleteRows', $_GET); ?>" data-name="rows[]"
                data-value="<?= http_build_query(array('id' => $model['UMessage']->id)); ?>" class="btn-delete-row"
                title="<?= Unitkit::t('unitkit', 'btn_delete'); ?>">
                <span class="glyphicon glyphicon-trash"></span>
            </a>
        	<?php endif; ?>
    	</div>
    </td>
    <td class="control-group">
        <?= $model['UMessage']->source; ?>
    </td>
    <td class="control-group <?=$model['UMessage']->hasErrors('u_message_group_id') ? 'error' : ''; ?>">
        <div class="input">
        	<?=
                UHtml::activeHiddenField(
                    $model['UMessage'],
                    'u_message_group_id',
                    array(
                        'class' => 'form-control input-sm input-ajax-select',
                        'name' => 'uMessages[' . $model['UMessage']->id . '][u_message_group_id]',
                        'id' => 'UMessageGroupI18nNameListTbodyRowEdit' . $model['UMessage']->id,
                        'data-action' => $this->createUrl($this->id . '/advComboBox/', array('name' => 'UMessageGroupI18n[name]','language' => Yii::app()->language)),
                        'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                        'data-text' => isset($relatedData['UMessageGroupI18n[name]'][$model['UMessage']->u_message_group_id]) ? $relatedData['UMessageGroupI18n[name]'][$model['UMessage']->u_message_group_id] : '',
                        'data-addAction' => $this->createUrl('messageGroup/create'),
                    )
                );
            ?>
		</div>
		<?php if ($model['UMessage']->hasErrors('u_message_group_id')): ?>
        <div class="help-inline"><?=UHtml::error($model['UMessage'], 'u_message_group_id'); ?></div>
        <?php endif; ?>
    </td>
	<?php foreach($relatedData['i18nIds'] as $i18nId): ?>
	<td class="control-group <?=$model['uMessageI18ns'][$i18nId]->hasErrors('translation') ? 'error' : ''; ?>">
        <div class="input">
        	<?=
                UHtml::activeTextArea(
                    $model['uMessageI18ns'][$i18nId],
                    'translation',
                    array(
                        'class' => 'form-control input-sm',
                        'name' => 'uMessageI18ns[' . $model['UMessage']->id . '][' . $i18nId . '][translation]',
                        'placeholder' => $model['uMessageI18ns'][$i18nId]->getAttributeLabel('translation'),
                        'id' => false
                    )
                );
            ?>
		</div>
		<?php if($model['uMessageI18ns'][$i18nId]->hasErrors('translation')): ?>
        <div class="help-inline"><?=UHtml::error($model['uMessageI18ns'][$i18nId], 'translation'); ?></div>
        <?php endif; ?>
    </td>
	<?php endforeach; ?>
</tr>