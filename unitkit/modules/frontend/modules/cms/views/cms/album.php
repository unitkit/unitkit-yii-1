<?php
Yii::app()
    ->clientScript
    ->registerScriptFile('/vendor/bower/fancybox/source/jquery.fancybox.pack.js')
    ->registerCssFile('/vendor/bower/fancybox/source/jquery.fancybox.css')
    ->registerScript('PageCmsAlbum', "
        $(document).ready(function() {
            $('.thumbnail').fancybox();
        });
    ");
?>
<?php for($i = 1, $n = count($this->cmsPageContents), $m = $n > BCmsPageContent::MAX_CONTAINER ? BCmsPageContent::MAX_CONTAINER : $n; $i <= $m; ++$i): ?>
    <?= isset($this->cmsPageContents[$i]) ? $this->cmsPageContents[$i] : ''; ?>
<?php endfor; ?>
