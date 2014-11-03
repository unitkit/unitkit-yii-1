<?php
Yii::app()
    ->clientScript
    ->registerDynamicScriptFile('/modules/message/js/jquery.backend.message.message.js')
    ->registerDynamicScript(
        'backendMessageMessageMain',
        Yii::app()->clientScript->getAppCrudMessages() . "
		var list = new $.backend.message.message.List({ main: '.list:first' });
		list.addAppSettings(new $.b.app.Settings({
			main: '#bMessageMessageMain .dynamic:first',
			list: list
		}));
		list.addAppEdit(new $.b.app.Edit({
			main: '#bMessageMessageMain .dynamic:first',
			list: list
		}));
		list.addAppTranslate(new $.b.app.Translate({
			main: '#bMessageMessageMain .dynamic:first',
			list: list
		}));
		list.initEvents();
        "
    );
?>
<div id="bMessageMessageMain">
    <div class="dynamic"></div>
    <div class="list">
        <?php
            $this->renderPartial('list/_list', array(
                'pagination' => $pagination,
                'models' => $models,
                'sort' => $sort,
                'model' => $model,
                'relatedDatas' => $relatedDatas,
                'isSaved' => $isSaved
            ));
        ?>
	</div>
</div>