<?php Yii::app()->clientScript->registerCssFile('/css/backend.simple.css'); ?>
<?php $this->beginContent('//../modules/backend/views/layouts/base'); ?>
<div id="content" class="container-fluid">
    <?php echo $content; ?>
</div>
<?php $this->endContent(); ?>