<tr>
    <td class="td-inline-action">
        <a href="<?= $this->createUrl($this->id.'/editRow', array_merge($dataView->pk, $_GET)); ?>" class="btn-update-row" title="<?= Unitkit::t('unitkit', 'btn_save'); ?>">
            <span class="glyphicon glyphicon-floppy-disk"></span>
        </a>
        <a href="<?= $this->createUrl($this->id.'/refreshRow', array_merge($dataView->pk, $_GET)); ?>" class="btn-close-row" title="<?= Unitkit::t('unitkit', 'btn_cancel'); ?>">
            <span class="glyphicon glyphicon-remove"></span>
        </a>
    </td>
	<?php foreach($dataView->items as $itemField): ?>
	<td class="<?= $itemField->model->hasErrors($itemField->attribute) ? 'has-error' : ''; ?>">
        <div class="input">
    		<?php if (! empty($itemField->type)): ?>
    			<?php if (! empty($itemField->datas)): ?>
    				<?= call_user_func_array('UHtml::'.$itemField->type, array($itemField->model, $itemField->attribute, $itemField->datas, $itemField->htmlOptions)); ?>
    			<?php else : ?>
    				<?= call_user_func_array('UHtml::'.$itemField->type, array($itemField->model, $itemField->attribute, $itemField->htmlOptions)); ?>
    			<?php endif; ?>
    		<?php elseif (! empty($itemField->value)): ?>
    			<?= $itemField->value; ?>
    		<?php endif; ?>
		</div>
		<?php if( $itemField->model->hasErrors($itemField->attribute)): ?>
        <div class="control-label"><?= UHtml::error($itemField->model, $itemField->attribute); ?></div>
        <?php endif; ?>
    </td>
	<?php endforeach; ?>
	<td></td>
</tr>