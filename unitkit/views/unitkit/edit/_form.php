<?php if($dataView->hasErrors): ?>
<div class="alert alert-danger">
	<?= UHtml::errorSummary($dataView->data); ?>
</div>
<?php endif; ?>

<?php if($dataView->isSaved): ?>
<div class="alert alert-success">
    <?php $this->bRenderPartial('edit/_formSuccess', array('dataView' => $dataView)); ?>
</div>
<?php endif; ?>

<form method="POST" action="<?= $dataView->action; ?>">
    <table class="table table-condensed">
        <tbody>
    		<?php $this->bRenderPartial('edit/_formBody', array('dataView' => $dataView)); ?>
    	</tbody>
        <tfoot>
            <?php $this->bRenderPartial('edit/_formFoot', array('dataView' => $dataView)); ?>
        </tfoot>
    </table>
</form>