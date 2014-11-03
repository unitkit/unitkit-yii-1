<?php foreach($dataView->relatedDatas['i18nIds'] as $i18nId): ?>
    <td>
        <?php $this->bRenderPartial('translate/_containerTable', array('dataView' => $dataView, 'i18nId' => $i18nId)); ?>
    </td>
<?php endforeach; ?>