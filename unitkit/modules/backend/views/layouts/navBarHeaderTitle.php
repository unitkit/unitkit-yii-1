<?php Yii::app()->clientScript->registerDynamicCssFile('/css/backend.navBar.css'); ?>
<?php $this->beginContent('//../modules/backend/views/layouts/base'); ?>
    <?php $this->widget('application.modules.backend.widgets.navBar.UNavBar'); ?>
    <div id="wrap">
        <div id="content" class="container-fluid container-header-title">
            <?= $content; ?>
        </div>
        <div id="push"></div>
    </div>
    <div id="footer">
        <div class="container-fluid text-center">
            UNITKIT © <?= date('Y'); ?>
        </div>
    </div>
<?php $this->endContent(); ?>