<div class="header-title">
    <button class="close btn-close">&times;</button>
    <h1><?= B::t('backend', 'message_message_create_title'); ?></h1>
</div>
<div class="inner-container">
<?php
    $this->renderPartial('edit/_form', array(
        'action' => 'create',
        'models' => $models,
        'relatedData' => $relatedData,
        'isSaved' => false,
        'pk' => $pk
    ));
?>
</div>