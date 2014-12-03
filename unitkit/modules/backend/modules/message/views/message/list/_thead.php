<tr class="tr-sort">
    <th class="th-quick-action"><span class="glyphicon glyphicon-list"></span></th>
    <th><?= BHtml::createBSortLink($sort, 'bMessage.source'); ?></th>
    <th><?= BHtml::createBSortLink($sort, 'bMessageGroupI18ns.name'); ?></th>
    <?php foreach($relatedData['i18nIds'] as $i18nId): ?>
    <th>
    	<?= BHtml::createBSortLink($sort, 'bMessageI18n_'.$i18nId.'.translation', BHtml::labelI18n($i18nId)); ?>
    </th>
    <?php endforeach; ?>
</tr>
<!-- sort -->

<tr class="tr-search form-inline" data-action="<?=$this->createUrl($this->id.'/list'); ?>">
    <td class="td-search">
        <a href="#" class="btn btn-sm btn-default btn-search" title="<?= B::t('unitkit', 'btn_search'); ?>">
            <span class="glyphicon glyphicon-search"></span>
        </a>
    </td>
    <td>
    	<?= BHtml::activeTextField($model, 'source', array('class' => 'form-control input-sm','name' => 'BMessageSearch[source]','placeholder' => B::t('unitkit', 'input_search'),'id' => false));?>
	</td>
    <td>
    	<?= BHtml::activeHiddenField($model, 'b_message_group_id', array('class' => 'form-control input-sm input-ajax-select allow-clear','name' => 'BMessageSearch[b_message_group_id]','id' => 'BMessageGroupI18n[name]:list:thead','data-action' => $this->createUrl($this->id . '/advComboBox/', array('name' => 'BMessageGroupI18n[name]','language' => Yii::app()->language)),'data-placeholder' => B::t('unitkit', 'input_select'),'data-text' => ! empty($model->b_message_group_id) ? BMessageGroupI18n::model()->findByPk(array('b_message_group_id' => $model->b_message_group_id,'i18n_id' => Yii::app()->language))->name : ''));?>
	</td>
	<?php foreach($relatedData['i18nIds'] as $i18nId): ?>
	<td>
    	<?= BHtml::activeTextField($model, 'ss_bMessageI18ns_translation[' . $i18nId . ']', array('class' => 'form-control input-sm','name' => 'BMessageSearch[ss_bMessageI18ns_translation][' . $i18nId . ']','placeholder' => B::t('unitkit', 'input_search'),'id' => false));?>
	</td>
	<?php endforeach ?>
</tr>
<!-- search -->