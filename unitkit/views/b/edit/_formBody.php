<?php foreach($dataView->items as $itemField): ?>
<tr>
    <th>
        <?php if (isset($itemField->attribute)) : ?>
            <?= $itemField->model->getAttributeLabel($itemField->attribute); ?>
        <?php elseif (isset($itemField->label)): ?>
            <?= $itemField->label; ?>
        <?php endif; ?>
    </th>
    <td class="<?= isset($itemField->attribute) && $itemField->model->hasErrors($itemField->attribute) ? 'has-error' : ''; ?>">
	<?php if (! empty($itemField->type)) : ?>
		<?php if (! empty($itemField->datas)) : ?>
			<?= call_user_func_array('BHtml::'.$itemField->type, array($itemField->model, $itemField->attribute, $itemField->datas, $itemField->htmlOptions)); ?>
		<?php else : ?>
			<?= call_user_func_array('BHtml::'.$itemField->type, array($itemField->model, $itemField->attribute, $itemField->htmlOptions)); ?>
		<?php endif; ?>
	<?php elseif (! empty($itemField->value)) : ?>
		<?= $itemField->value; ?>
	<?php endif; ?>
	</td>
</tr>
<?php endforeach;?>