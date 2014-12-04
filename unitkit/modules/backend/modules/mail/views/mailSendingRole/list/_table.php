<table class="table table-condensed">
    <tbody>
	<?php if($dataView->pagination->itemCount > 0) : ?>
    	<?php foreach($dataView->rows as $bListRowItem): ?>
			<?php $this->bRenderPartial('list/_tbodyRow', array('dataView' => $bListRowItem)); ?>
    	<?php endforeach; ?>
	<?php else : ?>
    	<tr>
            <td class="text-center"><em><?= Unitkit::t('unitkit', 'no_results'); ?></em></td>
        </tr>
	<?php endif; ?>
    </tbody>
</table>
<?php $this->bRenderPartial('list/_pager', array('dataView' => $dataView)); ?>