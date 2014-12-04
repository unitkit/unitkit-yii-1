<div class="header-title">
    <button class="close btn-close">&times;</button>
    <h1><?= Unitkit::t('backend', 'message_message_update_title'); ?></h1>
</div>
<div class="inner-container">
<?php
    $this->renderPartial('edit/_form', array(
        'action' => 'update',
        'models' => $models,
        'relatedData' => $relatedData,
        'isSaved' => $isSaved,
        'pk' => $pk
    ));
?>
</div>