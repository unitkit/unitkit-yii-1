<?php foreach($dataView->items as $itemField): ?>
<tr class="form-inline">
    <th><?= isset($itemField->label) ? $itemField->label : $dataView->model->getAttributeLabel($itemField->attribute); ?></th>
	<?php if (isset($itemField->value)): ?>
        <?= $itemField->value; ?>
	<?php else : ?>
    	<?php foreach($dataView->relatedData['i18nIds'] as $i18nId): ?>
        <td class="<?=$dataView->data[$i18nId][$itemField->model]->hasErrors($itemField->attribute) ? ' has-error' : '' ?>">
            <div class="input">
    		<?php if( ! empty($itemField->type)) : ?>
    			<?php $itemField->htmlOptions = array_merge($itemField->htmlOptions, array('name' => BHtml::modelName($dataView->data[$i18nId][$itemField->model]).'['.$i18nId.']['.$itemField->attribute.']')); ?>
    			<?= call_user_func_array('BHtml::'.$itemField->type, array($dataView->data[$i18nId][$itemField->model], $itemField->attribute, $itemField->htmlOptions)); ?>
    		<?php elseif( ! empty($itemField->value)) : ?>
    			<?= $itemField->value; ?>
    		<?php endif; ?>
    		</div>
    		<?php if($dataView->data[$i18nId][$itemField->model]->hasErrors($itemField->attribute)): ?>
    		<div class="control-label"><?= BHtml::error($dataView->data[$i18nId][$itemField->model], $itemField->attribute); ?></div>
    		<?php endif; ?>
    	</td>
    	<?php endforeach; ?>
	<?php endif; ?>
</tr>
<?php endforeach; ?>