<h4>
	<?= Unitkit::t('unitkit', 'advanced_search_title')?>
	<button type="button" class="close" aria-hidden="true">&times;</button>
</h4>

<form method="GET" action="<?=$this->createUrl($this->id.'/list'); ?>">
    <table class="table table-condensed">
        <tbody>
        	<?php foreach($dataView->advancedSearch as $val => $itemField): ?>
        		<?php $class = get_class($itemField); ?>
				<tr>
                <th><?= isset($itemField->displayAttribute) ? $itemField->displayAttribute : $itemField->model->getAttributeLabel($itemField->attribute); ?></th>
                <td class="form-inline">
            		<?php if($class === 'UItemField'): ?>
    		    		<?php if ( ! empty($itemField->type)) : ?>
    		    			<?php if (! empty($itemField->data)) : ?>
    		    				<?= call_user_func_array('UHtml::'.$itemField->type, array($itemField->model, $itemField->attribute, $itemField->data, $itemField->htmlOptions)); ?>
    		    			<?php else : ?>
    		    				<?= call_user_func_array('UHtml::'.$itemField->type, array($itemField->model, $itemField->attribute, $itemField->htmlOptions)); ?>
    		    			<?php endif; ?>
    		    		<?php elseif (! empty($itemField->value)) : ?>
    		    			<?= $itemField->value; ?>
    		    		<?php endif; ?>
    				<?php elseif($class === 'UDateRangeItemField'): ?>
    					<?= Unitkit::t('unitkit', 'date_range_between'); ?>
    					<?= call_user_func_array('UHtml::'.$itemField->start->type, array($itemField->start->model, $itemField->start->attribute, $itemField->start->htmlOptions)); ?>
    					<?= Unitkit::t('unitkit', 'date_range_separator'); ?>
    					<?= call_user_func_array('UHtml::'.$itemField->end->type, array($itemField->end->model, $itemField->end->attribute, $itemField->end->htmlOptions)); ?>
    				<?php endif; ?>
                </td>
            </tr>
        	<?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="text-center">
                    <a href="#" class="btn btn-primary btn-search">
                        <span class="glyphicon glyphicon-search"></span>
                        <span><?= Unitkit::t('unitkit', 'btn_search'); ?></span>
                    </a>
                </td>
            </tr>
        </tfoot>
    </table>
</form>