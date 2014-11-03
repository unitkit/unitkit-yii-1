<div class="header-title">
    <?php $this->bRenderPartial('list/_headerTitle', array('dataView' => $dataView)); ?>
</div>
<div class="inner-container">
    <div class="adv-search">
		<?php $this->bRenderPartial('list/_search', array('dataView' => $dataView)); ?>
	</div>
	<div class="refresh-cache-info"></div>
    <div class="grid">
		<?php $this->bRenderPartial('list/_table', array('dataView' => $dataView)); ?>
	</div>
</div>