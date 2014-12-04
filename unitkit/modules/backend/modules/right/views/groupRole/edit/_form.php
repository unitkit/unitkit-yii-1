<?php if($isSaved === false): ?>
<div class="alert alert-danger">
	<?=Unitkit::t('byblock','is_not_saved'); ?>
</div>
<?php elseif($isSaved === true): ?>
<div class="alert alert-success">
    <h4><?= Unitkit::t('unitkit', 'is_saved'); ?></h4>
</div>
<?php endif; ?>

<form method="POST" action="<?= $this->createUrl($this->id.'/edit'); ?>">
    <table class="table table-hover table-condensed">
        <thead>
            <tr>
                <th></th>
            	<?php foreach($models['UGroups'] as $group): ?>
            		<th><?= isset($group->uGroupI18ns[0]) ? $group->uGroupI18ns[0]->name : ''; ?></th>
            	<?php endforeach; ?>
        	</tr>
        </thead>
        <tbody>
        	<?php foreach($models['URoles'] as $role): ?>
        		<tr>
                <th><?= isset($role->uRoleI18ns[0]) ? $role->uRoleI18ns[0]->name : ''; ?></th>
        			<?php foreach($models['UGroups'] as $group): ?>
        			<td>
        			    <?= UHtml::hiddenField(get_class($models['UGroupRoles'][$group->id][$role->id]).'s['.$group->id.']['.$role->id.']', 0, array('id' => false,)); ?>
        			    <?= UHtml::checkBox(get_class($models['UGroupRoles'][$group->id][$role->id]) . 's[' . $group->id . '][' . $role->id . ']', $models['UGroupRoles'][$group->id][$role->id]->u_role_id == $role->id, array('id' => false));?>
        			</td>
        			<?php endforeach; ?>
        		</tr>
        	<?php endforeach; ?>
    	</tbody>
        <tfoot>
            <tr>
                <td colspan="<?= count($models['URoles']) + 1; ?>" class="text-center"><a href="#"
                    class="btn btn-primary btn-update"> <span class="glyphicon glyphicon-floppy-disk"></span> <span><?= Unitkit::t('unitkit', 'btn_save'); ?></span>
                </a></td>
            </tr>
            <!-- actions -->
        </tfoot>
    </table>
</form>