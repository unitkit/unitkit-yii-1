<?php
Yii::app()->clientScript
    ->registerDynamicScriptFile('/modules/cms/js/jquery.backend.cms.pageContainer.js')
    ->registerDynamicScript(
        $dataView->id,
        Yii::app()->clientScript->getAppCrudMessages() . "
		var list = new $.backend.cms.pageContainer.List({ main: '.list:first' });
		list.addAppSettings(new $.unitkit.app.Settings({
			main: '#".$dataView->id." .dynamic:first',
			list: list
		}));
		list.addAppEdit(new $.backend.cms.pageContainer.Edit({
			main: '#".$dataView->id." .dynamic:first',
			list: list
		}));
		list.addAppTranslate(new $.backend.cms.pageContainer.Translate({
			main: '#".$dataView->id." .dynamic:first',
			list: list
		}));
		list.initEvents();"
    );
?>
<div id="<?= $dataView->id; ?>">
    <div class="dynamic"></div>
    <div class="list">
		<?= $this->bRenderPartial('list/_list', array('dataView' => $dataView), true); ?>
	</div>
</div>