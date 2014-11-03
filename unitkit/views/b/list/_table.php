<table class="table table-hover table-condensed">
    <thead>
        <?= $this->bRenderPartial('list/_thead', array('dataView' => $dataView)); ?>
    </thead>
    <tbody>
    	<?php if($dataView->pagination->itemCount > 0) : ?>
	    	<?php foreach($dataView->rows as $bListRowItem): ?>
				<?php $this->bRenderPartial('list/_tbodyRow', array('dataView' => $bListRowItem)); ?>
	    	<?php endforeach; ?>
    	<?php else : ?>
        <tr>
            <td colspan="<?= count($dataView->sortAttributes) + 2; ?>" class="text-center">
                <em><?= B::t('unitkit', 'no_results'); ?></em>
            </td>
        </tr>
    	<?php endif; ?>
    </tbody>
    <tfoot>
		<?php $this->bRenderPartial('list/_tfoot', array('dataView' => $dataView)); ?>
    </tfoot>
</table>
<?php $this->bRenderPartial('list/_pager', array('dataView' => $dataView)); ?>