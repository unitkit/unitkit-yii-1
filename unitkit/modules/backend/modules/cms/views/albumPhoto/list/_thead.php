<tr class="tr-sort">
    <th class="th-quick-action"><span class="glyphicon glyphicon-list"></span></th>
	<?php foreach($dataView->sortAttributes as $attribute): ?>
		<th><?= BHtml::createBSortLink($dataView->sort, $attribute); ?></th>
	<?php endforeach; ?>
	<th class="th-action"><i class="icon-th-list"></i></th>
</tr>
<tr class="tr-search form-inline" data-action="<?=$this->createUrl($this->id.'/list', $_GET); ?>">
    <td class="td-search">
        <a href="#" class="btn btn-sm btn-default btn-search" title="<?= B::t('unitkit', 'btn_search'); ?>">
            <span class="glyphicon glyphicon-search"></span>
        </a>
    </td>
	<?php foreach($dataView->gridSearch as $itemField): ?>
		<?php $class = get_class($itemField); ?>
	<td>
		<?php if($class === 'BItemField'): ?>
    		<?php if( ! empty($itemField->type)) : ?>
    			<?php if( ! empty($itemField->datas)) : ?>
    				<?= call_user_func_array('BHtml::'.$itemField->type, array($itemField->model, $itemField->attribute, $itemField->datas, $itemField->htmlOptions)); ?>
    			<?php else : ?>
    				<?= call_user_func_array('BHtml::'.$itemField->type, array($itemField->model, $itemField->attribute, $itemField->htmlOptions)); ?>
    			<?php endif; ?>
    		<?php elseif( ! empty($itemField->value)) : ?>
    			<?= $itemField->value; ?>
    		<?php endif; ?>
		<?php elseif($class === 'BDateRangeItemField'): ?>
			<?= B::t('unitkit', 'date_range_between'); ?>
			<?= call_user_func_array('BHtml::'.$itemField->start->type, array($itemField->start->model, $itemField->start->attribute, $itemField->start->htmlOptions)); ?>
			<?= B::t('unitkit', 'date_range_separator'); ?>
			<?= call_user_func_array('BHtml::'.$itemField->end->type, array($itemField->end->model, $itemField->end->attribute, $itemField->end->htmlOptions)); ?>
		<?php endif; ?>
	</td>
	<?php endforeach; ?>
	<td class="td-search">
        <a href="#" class="btn btn-sm btn-default btn-search" title="<?= B::t('unitkit', 'btn_search'); ?>">
	       <span class="glyphicon glyphicon-search"></span>
        </a>
    </td>
</tr>