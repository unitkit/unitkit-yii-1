<?php foreach($dataView->items as $itemField): ?>
<tr class="form-inline">
    <th><?= isset($itemField->label) ? $itemField->label : $dataView->model->getAttributeLabel($itemField->attribute); ?></th>
	<?php foreach($dataView->relatedDatas['i18nIds'] as $i18nId): ?>
    <td class="<?=$dataView->datas[$i18nId]->hasErrors($itemField->attribute) ? ' has-error' : '' ?>">
        <div class="input">
		<?php if( ! empty($itemField->type)) : ?>
			<?php $itemField->htmlOptions = array_merge($itemField->htmlOptions, array('name' => BHtml::modelName($dataView->datas[$i18nId]->model()).'['.$i18nId.']['.$itemField->attribute.']')); ?>
			<?php if( ! empty($itemField->datas)) : ?>
				<?= call_user_func_array('BHtml::'.$itemField->type, array($dataView->datas[$i18nId], $itemField->attribute, $itemField->datas, $itemField->htmlOptions)); ?>
			<?php else : ?>
				<?= call_user_func_array('BHtml::'.$itemField->type, array($dataView->datas[$i18nId], $itemField->attribute, $itemField->htmlOptions)); ?>
			<?php endif; ?>
		<?php elseif( ! empty($itemField->value)) : ?>
			<?= $itemField->value; ?>
		<?php endif; ?>
		</div>
		<?php if($dataView->datas[$i18nId]->hasErrors($itemField->attribute)): ?>
		<div class="control-label"><?= BHtml::error($dataView->datas[$i18nId], $itemField->attribute); ?></div>
		<?php endif; ?>
	</td>
	<?php endforeach; ?>
</tr>
<?php endforeach; ?>