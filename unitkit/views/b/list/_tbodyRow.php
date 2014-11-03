<tr class="form-inline">
    <td class="form-inline td-inline-action">
		<?php if( Yii::app()->user->checkMultiAccess($this->getDefaultRoles('delete'))): ?>
		<div class="form-group">
            <label class="checkbox">
			    <?=BHtml::checkBox('rows[]', false, array('class' => 'check-row','id' => false,'value' => http_build_query($dataView->pk))); ?>
			</label>
        </div>
		<?php endif; ?>

		<div class="form-group">
			<?php if(Yii::app()->user->checkMultiAccess($this->getDefaultRoles('update'))): ?>
			<a href="<?= $this->createUrl($this->id.'/editRow', array_merge($_GET, $dataView->pk)); ?>" class="btn-edit-row"
                title="<?= B::t('unitkit', 'btn_edit_inline'); ?>">
                <span class="glyphicon glyphicon-edit"></span>
            </a>
			<?php endif ?>

			<?php if(Yii::app()->user->checkMultiAccess($this->getDefaultRoles('delete'))): ?>
			<a href="<?= $this->createUrl($this->id.'/deleteRows', $_GET); ?>" data-name="rows[]"
                data-value="<?=http_build_query($dataView->pk); ?>" class="btn-delete-row"
                title="<?= B::t('unitkit', 'btn_delete'); ?>">
                <span class="glyphicon glyphicon-trash"></span>
            </a>
			<?php endif; ?>
		</div>
    </td>

	<?php foreach($dataView->items as $item): ?>
	<td><?= $item; ?></td>
	<?php endforeach; ?>

	<td class="td-action">
		<?php $this->bRenderPartial('list/_tbodyRowAction', array('dataView' => $dataView)); ?>
	</td>
</tr>