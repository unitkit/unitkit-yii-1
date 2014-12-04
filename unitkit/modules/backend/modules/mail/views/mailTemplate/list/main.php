<?php
Yii::app()
    ->clientScript
    ->registerDynamicCssFile('/modules/mail/css/backend.mail.mailTemplate.css')
    ->registerDynamicScriptFile('/modules/mail/js/jquery.backend.mail.mailTemplate.js')
    ->registerDynamicScript(
        $dataView->id,
        Yii::app()->clientScript->getAppCrudMessages()."
    	var list = new $.backend.mail.mailTemplate.List({main: '#" . $dataView->id . " .list:first'});
    	list.addAppSettings(new $.unitkit.app.Settings({
    		main: '#" . $dataView->id . " .dynamic:first',
    		list: list
    	}));
    	list.addAppEdit(new $.unitkit.app.Edit({
    		main: '#" . $dataView->id . " .dynamic:first',
    		list: list
    	}));
    	list.addAppTranslate(new $.unitkit.app.Translate({
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