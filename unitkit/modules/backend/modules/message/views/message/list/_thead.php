<tr class="tr-sort">
    <th class="th-quick-action"><span class="glyphicon glyphicon-list"></span></th>
    <th><?= UHtml::createBSortLink($sort, 'uMessage.source'); ?></th>
    <th><?= UHtml::createBSortLink($sort, 'uMessageGroupI18ns.name'); ?></th>
    <?php foreach($relatedData['i18nIds'] as $i18nId): ?>
    <th>
    	<?= UHtml::createBSortLink($sort, 'uMessageI18n_'.$i18nId.'.translation', UHtml::labelI18n($i18nId)); ?>
    </th>
    <?php endforeach; ?>
</tr>
<!-- sort -->

<tr class="tr-search form-inline" data-action="<?=$this->createUrl($this->id.'/list'); ?>">
    <td class="td-search">
        <a href="#" class="btn btn-sm btn-default btn-search" title="<?= Unitkit::t('unitkit', 'btn_search'); ?>">
            <span class="glyphicon glyphicon-search"></span>
        </a>
    </td>
    <td>
    	<?= UHtml::activeTextField($model, 'source', array('class' => 'form-control input-sm','name' => 'UMessageSearch[source]','placeholder' => Unitkit::t('unitkit', 'input_search'),'id' => false));?>
	</td>
    <td>
    	<?= UHtml::activeHiddenField($model, 'u_message_group_id', array('class' => 'form-control input-sm input-ajax-select allow-clear','name' => 'UMessageSearch[u_message_group_id]','id' => 'UMessageGroupI18n[name]:list:thead','data-action' => $this->createUrl($this->id . '/advComboBox/', array('name' => 'UMessageGroupI18n[name]','language' => Yii::app()->language)),'data-placeholder' => Unitkit::t('unitkit', 'input_select'),'data-text' => ! empty($model->u_message_group_id) ? UMessageGroupI18n::model()->findByPk(array('u_message_group_id' => $model->u_message_group_id,'i18n_id' => Yii::app()->language))->name : ''));?>
	</td>
	<?php foreach($relatedData['i18nIds'] as $i18nId): ?>
	<td>
    	<?= UHtml::activeTextField($model, 'lk_uMessageI18ns_translation[' . $i18nId . ']', array('class' => 'form-control input-sm','name' => 'UMessageSearch[lk_uMessageI18ns_translation][' . $i18nId . ']','placeholder' => Unitkit::t('unitkit', 'input_search'),'id' => false));?>
	</td>
	<?php endforeach ?>
</tr>
<!-- search -->