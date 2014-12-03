<h4>
	<?= B::t('unitkit', 'advanced_search_title'); ?>
	<button type="button" class="close" aria-hidden="true">&times;</button>
</h4>

<form method="GET" action="<?=$this->createUrl($this->id.'/list') ?>">
    <table class="table table-condensed">
        <tbody>
            <tr>
                <th><?= $model->getAttributeLabel('b_message_group_id'); ?></th>
                <td>
                <?=
                    BHtml::activeHiddenField(
        	           $model,
        	           'b_message_group_id',
        	           array(
        	               'class' => 'input-ajax-select',
        	               'name' => 'BMessageSearch[b_message_group_id]',
        	               'id' => 'BMessageGroupI18nNameListSearch',
        	               'data-action' => $this->createUrl(
                                $this->id . '/advComboBox/',
                                array(
                                    'name' => 'BMessageGroupI18n[name]',
                                    'language' => Yii::app()->language
        	                   )
                            ),
                            'data-placeholder' => B::t('unitkit', 'input_select'),
                            'data-text' => ! empty($model->b_message_group_id) ? BMessageGroupI18n::model()->findByPk(array('b_message_group_id' => $model->b_message_group_id,'i18n_id' => Yii::app()->language))->name : ''
                        )
                    );
                ?>
        		</td>
            </tr>
            <tr>
                <th><?= $model->getAttributeLabel('source'); ?></th>
                <td class="control-group">
            	<?=
                    BHtml::activeTextField(
                        $model,
                        'source',
                        array('class' => 'form-control input-sm', 'name' => 'BMessageSearch[source]', 'placeholder' => B::t('unitkit', 'input_search'), 'id' => false)
                    );
                ?>
        		</td>
            </tr>
            <?php foreach($relatedData['i18nIds'] as $i18nId): ?>
            <tr>
                <th><?= BHtml::labelI18n($i18nId); ?></th>
                <td class="control-group">
			    	<?=
			    	    BHtml::activeTextField(
                            $model,
                            'ss_bMessageI18ns_translation[' . $i18nId . ']',
                            array('class' => 'form-control input-sm','name' => 'BMessageSearch[ss_bMessageI18ns_translation][' . $i18nId . ']','placeholder' => B::t('unitkit', 'input_search'),'id' => false)
                        );
                    ?>
				</td>
            </tr>
			<?php endforeach ;?>
        </tbody>

        <tfoot>
            <tr>
                <td colspan="2" class="text-center">
                    <a href="#" class="btn btn-primary btn-search">
                        <span class="glyphicon glyphicon-search"></span>
                        <span><?= B::t('unitkit', 'btn_search'); ?></span>
                    </a>
                </td>
            </tr>
        </tfoot>
    </table>
</form>