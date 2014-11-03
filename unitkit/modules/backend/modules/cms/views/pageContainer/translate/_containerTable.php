<table class="table">
    <tbody>
    <?php foreach ($dataView->datas[$i18nId]['BCmsPageContentI18ns'] as $index => $cmsPageContentI18n): ?>
        <tr>
            <td>
                <div><?= B::t('backend', 'cms_page_container_index').' '.$index?></div>
                <?php foreach($dataView->items as $itemField): ?>
                    <?php
                        $this->bRenderPartial('translate/_containerRowCell', array(
                            'itemField' => $itemField,
                            'cmsPageContentI18n' => $cmsPageContentI18n,
                            'index' => $index,
                            'i18nId' => $i18nId
                        ));
                    ?>
            	<?php endforeach; ?>
        	</td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>