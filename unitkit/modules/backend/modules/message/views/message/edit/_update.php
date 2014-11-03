<div class="header-title">
    <button class="close btn-close">&times;</button>
    <h1><?= B::t('backend', 'message_message_update_title'); ?></h1>
</div>
<div class="inner-container">
<?php
    $this->renderPartial('edit/_form', array(
        'action' => 'update',
        'models' => $models,
        'relatedDatas' => $relatedDatas,
        'isSaved' => $isSaved,
        'pk' => $pk
    ));
?>
</div>