<tr class="form-inline">
    <td class="form-inline td-inline-action">
		<div class="form-group">
			<?php if(Yii::app()->user->checkMultiAccess($this->defaultRoles['update'])): ?>
			<a href="<?= $this->createUrl($this->id.'/editRow', array_merge($_GET, $dataView->pk)); ?>" class="btn-edit-row"
                title="<?= Unitkit::t('unitkit', 'btn_edit_inline'); ?>"><span class="glyphicon glyphicon-edit"></span></a>
			<?php endif; ?>

			<?php if(Yii::app()->user->checkMultiAccess($this->defaultRoles['delete'])): ?>
			<a href="<?= $this->createUrl($this->id.'/deleteRows', $_GET); ?>" data-name="rows[]"
                data-value="<?=http_build_query($dataView->pk); ?>" class="btn-delete-row"
                title="<?= Unitkit::t('unitkit', 'btn_delete'); ?>"><span class="glyphicon glyphicon-trash"></span></a>
			<?php endif; ?>
		</div>
    </td>
	<?php foreach($dataView->items as $item): ?>
	<td><?= $item; ?></td>
	<?php endforeach; ?>
</tr>