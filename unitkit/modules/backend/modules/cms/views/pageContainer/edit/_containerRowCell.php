<td class="<?= isset($itemField->attribute) && $itemField->model->hasErrors($itemField->attribute) ? 'has-error' : ''; ?>">
    <div class="input">
		<?php if (! empty($itemField->type)): ?>
			<?php if (! empty($itemField->datas)): ?>
				<?= call_user_func_array('BHtml::'.$itemField->type, array($itemField->model, $itemField->attribute, $itemField->datas, $itemField->htmlOptions)); ?>
			<?php else : ?>
				<?= call_user_func_array('BHtml::'.$itemField->type, array($itemField->model, $itemField->attribute, $itemField->htmlOptions)); ?>
			<?php endif; ?>
		<?php elseif (! empty($itemField->value)): ?>
			<?= $itemField->value; ?>
		<?php endif; ?>
	</div>
	<?php if( isset($itemField->attribute) && $itemField->model->hasErrors($itemField->attribute)): ?>
    <div class="control-label"><?= BHtml::error($itemField->model, $itemField->attribute); ?></div>
    <?php endif; ?>
</td>