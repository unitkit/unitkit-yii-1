<?php Yii::app()->clientScript->registerDynamicCssFile('/css/backend.simpleHeaderTitle.css'); ?>
<?php $this->beginContent('//../modules/backend/views/layouts/simple'); ?>
<div id="content" class="container-fluid">
    <?php echo $content; ?>
</div>
<?php $this->endContent(); ?>