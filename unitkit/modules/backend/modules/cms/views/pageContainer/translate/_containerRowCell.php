<div class="<?= $cmsPageContentI18n->hasErrors($itemField->attribute) ? ' has-error' : '' ?>">
    <div class="input">
	<?php if (! empty($itemField->type)) : ?>
		<?php $itemField->htmlOptions = array_merge($itemField->htmlOptions, array('name' => BHtml::modelName($cmsPageContentI18n).'['.$i18nId.']['.$index.']['.$itemField->attribute.']')); ?>
		<?= call_user_func_array('BHtml::'.$itemField->type, array($cmsPageContentI18n, $itemField->attribute, $itemField->htmlOptions)); ?>
	<?php elseif (! empty($itemField->value)) : ?>
		<?= $itemField->value; ?>
	<?php endif; ?>
	</div>
	<?php if ($cmsPageContentI18n->hasErrors($itemField->attribute)): ?>
	<div class="control-label"><?= BHtml::error($cmsPageContentI18n, $itemField->attribute); ?></div>
	<?php endif; ?>
</div>