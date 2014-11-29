<?php
Yii::app()->clientScript
    ->registerScript(
        'cmsIndex',
        "$('.carousel').carousel({
            interval: 5000 //changes the speed
        });"
    );
?>
<?php for($i = 1, $n = count($this->cmsPageContents), $m = $n > BCmsPageContent::MAX_CONTAINER ? BCmsPageContent::MAX_CONTAINER : $n; $i <= $m; ++$i): ?>
    <?= isset($this->cmsPageContents[$i]) ? $this->cmsPageContents[$i] : ''; ?>
<?php endfor; ?>