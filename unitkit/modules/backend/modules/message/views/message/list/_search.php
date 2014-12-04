<h4>
	<?= Unitkit::t('unitkit', 'advanced_search_title'); ?>
	<button type="button" class="close" aria-hidden="true">&times;</button>
</h4>

<form method="GET" action="<?=$this->createUrl($this->id.'/list') ?>">
    <table class="table table-condensed">
        <tbody>
            <tr>
                <th><?= $model->getAttributeLabel('u_message_group_id'); ?></th>
                <td>
                <?=
                    UHtml::activeHiddenField(
        	           $model,
        	           'u_message_group_id',
        	           array(
        	               'class' => 'input-ajax-select',
        	               'name' => 'UMessageSearch[u_message_group_id]',
        	               'id' => 'UMessageGroupI18nNameListSearch',
        	               'data-action' => $this->createUrl(
                                $this->id . '/advComboBox/',
                                array(
                                    'name' => 'UMessageGroupI18n[name]',
                                    'language' => Yii::app()->language
        	                   )
                            ),
                            'data-placeholder' => Unitkit::t('unitkit', 'input_select'),
                            'data-text' => ! empty($model->u_message_group_id) ? UMessageGroupI18n::model()->findByPk(array('u_message_group_id' => $model->u_message_group_id,'i18n_id' => Yii::app()->language))->name : ''
                        )
                    );
                ?>
        		</td>
            </tr>
            <tr>
                <th><?= $model->getAttributeLabel('source'); ?></th>
                <td class="control-group">
            	<?=
                    UHtml::activeTextField(
                        $model,
                        'source',
                        array('class' => 'form-control input-sm', 'name' => 'UMessageSearch[source]', 'placeholder' => Unitkit::t('unitkit', 'input_search'), 'id' => false)
                    );
                ?>
        		</td>
            </tr>
            <?php foreach($relatedData['i18nIds'] as $i18nId): ?>
            <tr>
                <th><?= UHtml::labelI18n($i18nId); ?></th>
                <td class="control-group">
			    	<?=
			    	    UHtml::activeTextField(
                            $model,
                            'lk_uMessageI18ns_translation[' . $i18nId . ']',
                            array('class' => 'form-control input-sm','name' => 'UMessageSearch[lk_uMessageI18ns_translation][' . $i18nId . ']','placeholder' => Unitkit::t('unitkit', 'input_search'),'id' => false)
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
                        <span><?= Unitkit::t('unitkit', 'btn_search'); ?></span>
                    </a>
                </td>
            </tr>
        </tfoot>
    </table>
</form>