<table class="table">
    <tbody>
    <?php foreach($dataView->rows as $bArrayRowItem): ?>
        <tr>
            <?php foreach($bArrayRowItem->items as $itemField): ?>
        	   <?php $this->bRenderPartial('edit/_containerRowCell', array('itemField' => $itemField)); ?>
        	<?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>