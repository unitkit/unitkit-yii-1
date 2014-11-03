<?php if($isSaved === false): ?>
<div class="alert alert-danger">
	<?=B::t('byblock','is_not_saved'); ?>
</div>
<?php elseif($isSaved === true): ?>
<div class="alert alert-success">
    <h4><?= B::t('unitkit', 'is_saved'); ?></h4>
</div>
<?php endif; ?>

<form method="POST" action="<?= $this->createUrl($this->id.'/edit'); ?>">
    <table class="table table-hover table-condensed">
        <thead>
            <tr>
                <th></th>
            	<?php foreach($models['BGroups'] as $group): ?>
            		<th><?= isset($group->bGroupI18ns[0]) ? $group->bGroupI18ns[0]->name : ''; ?></th>
            	<?php endforeach; ?>
        	</tr>
        </thead>
        <tbody>
        	<?php foreach($models['BRoles'] as $role): ?>
        		<tr>
                <th><?= isset($role->bRoleI18ns[0]) ? $role->bRoleI18ns[0]->name : ''; ?></th>
        			<?php foreach($models['BGroups'] as $group): ?>
        			<td>
        			    <?= BHtml::hiddenField(get_class($models['BGroupRoles'][$group->id][$role->id]).'s['.$group->id.']['.$role->id.']', 0, array('id' => false,)); ?>
        			    <?= BHtml::checkBox(get_class($models['BGroupRoles'][$group->id][$role->id]) . 's[' . $group->id . '][' . $role->id . ']', $models['BGroupRoles'][$group->id][$role->id]->b_role_id == $role->id, array('id' => false));?>
        			</td>
        			<?php endforeach; ?>
        		</tr>
        	<?php endforeach; ?>
    	</tbody>
        <tfoot>
            <tr>
                <td colspan="<?= count($models['BRoles']) + 1; ?>" class="text-center"><a href="#"
                    class="btn btn-primary btn-update"> <span class="glyphicon glyphicon-floppy-disk"></span> <span><?= B::t('unitkit', 'btn_save'); ?></span>
                </a></td>
            </tr>
            <!-- actions -->
        </tfoot>
    </table>
</form>