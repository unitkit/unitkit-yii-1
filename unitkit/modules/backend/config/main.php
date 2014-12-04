<?php
// Application path
Yii::setPathOfAlias('application', dirname(__FILE__) . '/../../..');

return array(
    // application ID (should be unique)
    'id' => '',
    'name' => 'Backend',
    'basePath' => Yii::getPathOfAlias('application'),
    'preload' => array(
        'log'
    ),
    // autoloading model and component classes
    'import' => array(
        'application.components.*',
        'application.components.dataView.*',
        'application.models.*',
        'application.modules.backend.models.*',
        'application.modules.backend.components.*',
        'application.modules.backend.vendor.EScriptBoost.*'
    ),
    'defaultController' => 'backend/auth/auth',
    'sourceLanguage' => '?',
    // default language
    'language' => 'en',
    // list of activated modules
    'modules' => array(
        'backend' => array(
            'modules' => array(
                'site',
                'auth',
                'autoLogin',
                'passwordReset',
                'dashboard',
                'variable',
                'message',
                'i18n',
                'right',
                'profile',
                'cache',
                'post',
                'photo',
                'mail',
                'cms' => array(
                    'imagePathDest' => Yii::getPathOfAlias('application').'/../public/static/cms/images',
            	    'imageUrlDest' => '//static.unitkit.local/cms/images',
                    'albumPhotoPathDest' => Yii::getPathOfAlias('application').'/../public/static/cms/albums',
                    'albumPhotoUrlDest' => '//static.unitkit.local/cms/albums',
                    'components' => array(
                        'albumPhotoUploader' => array(
                        	'class' => 'application.modules.backend.modules.cms.components.albumPhoto.AlbumPhotoUploader',
                            'pathTmp' => Yii::getPathOfAlias('application').'/../datas/tmp',
                        ),
                        'imageUploader' => array(
                            'class' => 'application.modules.backend.modules.cms.components.image.ImageUploader',
                            'pathTmp' => Yii::getPathOfAlias('application').'/../datas/tmp',
                        )
                    )
                ),
            )
        )
    ),
    // application components
    'components' => array(
        'phpThumb' => array(
            'class' => 'application.modules.backend.vendor.EPhpThumb.EPhpThumb',
            'options' => array()
        ),
        'uploader' => array(
            'class' => 'application.components.UUploader',
            'pathTmp' => Yii::getPathOfAlias('application').'/../datas/tmp',
        ),
        'variables' => array(
            'class' => 'application.components.UDbVariable',
            'cacheID' => 'varCache'
        ),
        'rights' => array(
            'class' => 'application.components.UDbRight',
            'cacheID' => 'rightCache'
        ),
        'mail' => array(
            'class' => 'application.modules.backend.components.UMail',
            'classFunction' => 'UMailFunction'
        ),
        'clientScript' => array(
            'class' => 'application.modules.backend.components.UClientScript'
        ),
        'request' => array(
            'class' => 'application.components.UHttpRequest',
            'enableCsrfValidation' => true
        ),
        'session' => array(
            'class' => 'application.components.UHttpSession'
        ),
        'user' => array(
            'class' => 'application.modules.backend.components.UWebUser',
            'allowAutoLogin' => true,
            'loginUrl' => array(
                'auth/auth/login'
            )
        ),
        'messages' => array(
            'class' => 'application.components.UDbMessageSource',
            'cacheID' => 'messCache'
        ),
        'mailer' => array(
            'class' => 'application.modules.backend.vendor.mailer.EMailer',
            'pathViews' => 'application.views.email',
            'pathLayouts' => 'application.views.email.layouts',
            // See phpmailer documentation
            //'Mailer' => 'smtp',
            //'Host' => ''
        ),
        'urlManager' => array(
            'class' => 'application.modules.backend.components.UUrlManager',
            'urlFormat' => 'path',
            'showScriptName' => false,
            'cacheID' => 'urlCache'
        ),
        // generic cache
        'cache' => array(
            'class' => 'CFileCache',
            'keyPrefix' => 'b:app:backend:main',
        ),
        // cms cache
        'cmsCache' => array(
            'class' => 'CFileCache',
            'keyPrefix' => 'b:app:cms',
        ),
        // variable cache
        'varCache' => array(
            'class' => 'CFileCache',
            'keyPrefix' => 'b:app:var',
        ),
        // database cache
        'DBCache' => array(
            'class' => 'CFileCache',
            'keyPrefix' => 'b:app:db',
        ),
        // rights cache
        'rightCache' => array(
            'class' => 'CFileCache',
            'keyPrefix' => 'b:app:backend:right',
        ),
        // messages cache
        'messCache' => array(
            'class' => 'CFileCache',
            'keyPrefix' => 'b:app:message',
        ),
        // url rules cache
        'urlCache' => array(
            'class' => 'CFileCache',
            'keyPrefix' => 'b:app:backend:url',
        ),
        // url rules cache
        'i18nCache' => array(
            'class' => 'CFileCache',
            'keyPrefix' => 'b:app:i18n',
        ),
        // db connector
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=unitkit',
            'charset' => 'utf8',
            'username' => 'unitkit',
            'password' => 'unitkit',
            'enableProfiling' => YII_DEBUG,
            'enableParamLogging' => YII_DEBUG,
            'schemaCachingDuration' => 2592000,
            'schemaCacheID' => 'DBCache',
            'queryCacheID' => 'DBCache'
        ),
        'errorHandler' => array(
            'errorAction' => 'backend/site/site/error'
        ),
        // log
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'error, warning',
				),
				array(
                    'class' => 'CWebLogRoute',
                    'levels' => 'trace, info',
                    'categories' => 'system.db.*',
                    'enabled' => true
                )
            )
        )
    ),
    'params' => array(
        'baseModuleApplication' => 'backend'
    )
);