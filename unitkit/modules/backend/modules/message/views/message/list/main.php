<?php
Yii::app()
    ->clientScript
    ->registerDynamicScriptFile('/modules/message/js/jquery.backend.message.message.js')
    ->registerDynamicScript(
        'backendMessageMessageMain',
        Yii::app()->clientScript->getAppCrudMessages() . "
		var list = new $.backend.message.message.List({ main: '#uMessageMessageMain     .list:first' });
		list.addAppSettings(new $.unitkit.app.Settings({
			main: '#uMessageMessageMain .dynamic:first',
			list: list
		}));
		list.addAppEdit(new $.unitkit.app.Edit({
			main: '#uMessageMessageMain .dynamic:first',
			list: list
		}));
		list.addAppTranslate(new $.unitkit.app.Translate({
			main: '#uMessageMessageMain .dynamic:first',
			list: list
		}));
		list.initEvents();
        "
    );
?>
<div id="uMessageMessageMain">
    <div class="dynamic"></div>
    <div class="list">
        <?php
            $this->renderPartial('list/_list', array(
                'pagination' => $pagination,
                'models' => $models,
                'sort' => $sort,
                'model' => $model,
                'relatedData' => $relatedData,
                'isSaved' => $isSaved
            ));
        ?>
	</div>
</div>