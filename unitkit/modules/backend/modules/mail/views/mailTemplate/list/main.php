<?php
Yii::app()
    ->clientScript
    ->registerDynamicCssFile('/modules/mail/css/backend.mail.mailTemplate.css')
    ->registerDynamicScriptFile('/modules/mail/js/jquery.backend.mail.mailTemplate.js')
    ->registerDynamicScript(
        $dataView->id,
        Yii::app()->clientScript->getAppCrudMessages()."
    	var list = new $.backend.mail.mailTemplate.List({main: '#" . $dataView->id . " .list:first'});
    	list.addAppSettings(new $.b.app.Settings({
    		main: '#" . $dataView->id . " .dynamic:first',
    		list: list
    	}));
    	list.addAppEdit(new $.b.app.Edit({
    		main: '#" . $dataView->id . " .dynamic:first',
    		list: list
    	}));
    	list.addAppTranslate(new $.b.app.Translate({
    		main: '#" . $dataView->id . " .dynamic:first',
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