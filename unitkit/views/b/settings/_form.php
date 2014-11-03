<?php if($dataView->hasErrors): ?>
<div class="alert alert-danger">
	<?= BHtml::errorSummary($dataView->datas); ?>
</div>
<?php endif; ?>

<?php if($dataView->isSaved): ?>
<div class="alert alert-success">
    <h4><?= B::t('unitkit', 'is_saved'); ?></h4>
    <div class="action-success">
        <a class="btn btn-default btn-close" href="<?= $dataView->closeAction; ?>">
            <span><?= B::t('unitkit', 'btn_close'); ?></span>
        </a>
    </div>
</div>
<?php endif; ?>

<form method="POST" action="<?= $dataView->action; ?>">
    <table class="table table-condensed">
		<?php foreach($dataView->items as $itemField): ?>
    	<tr>
            <th><?= $itemField->model->getAttributeLabel($itemField->attribute); ?></th>
            <td class="<?= $itemField->model->hasErrors($itemField->attribute) ? 'has-error' : ''; ?>">
	    	<?php if (! empty($itemField->type)): ?>
	    		<?= call_user_func_array('BHtml::'.$itemField->type, array($itemField->model, $itemField->attribute, $itemField->htmlOptions)); ?>
	    	<?php elseif (! empty($itemField->value)): ?>
	    		<?= $itemField->value; ?>
	    	<?php endif; ?>
    		</td>
        </tr>
		<?php endforeach;?>
		<tr>
            <th></th>
            <td>
                <button class="btn btn-primary btn-update">
                    <span class="glyphicon glyphicon-floppy-disk"></span>
                    <span><?= B::t('unitkit', 'btn_save'); ?></span>
                </button>
                <a href="<?= $dataView->closeAction; ?>" class="btn btn-default btn-close">
                    <span><?= B::t('unitkit', 'btn_close'); ?></span>
                </a>
            </td>
        </tr>
    </table>
</form>