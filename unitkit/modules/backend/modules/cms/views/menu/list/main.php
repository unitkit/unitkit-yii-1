<?php
Yii::app()->clientScript
    ->registerDynamicScriptFile('/modules/cms/js/jquery.backend.cms.menu.js')
    ->registerDynamicScript(
        $dataView->id,
        Yii::app()->clientScript->getAppCrudMessages() . "
		var list = new $.backend.cms.menu.List({ main: '.list:first' });
		list.addAppSettings(new $.b.app.Settings({
			main: '#".$dataView->id." .dynamic:first',
			list: list
		}));
		list.addAppEdit(new $.backend.cms.menu.Edit({
			main: '#".$dataView->id." .dynamic:first',
			list: list
		}));
		list.addAppTranslate(new $.backend.cms.menu.Translate({
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