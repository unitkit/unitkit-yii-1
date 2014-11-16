<?php
// Application path
Yii::setPathOfAlias('application', dirname(__FILE__) . '/../../..');

return array(
    // application ID (should be unique)
    'id' => 'ezdezdezdezd',
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
            'class' => 'application.components.BUploader',
            'pathTmp' => Yii::getPathOfAlias('application').'/../datas/tmp',
        ),
        'variables' => array(
            'class' => 'application.components.BDbVariable',
            'cacheID' => 'varCache'
        ),
        'rights' => array(
            'class' => 'application.components.BDbRight',
            'cacheID' => 'rightCache'
        ),
        'mail' => array(
            'class' => 'application.modules.backend.components.BMail',
            'classFunction' => 'BMailFunction'
        ),
        'clientScript' => array(
            'class' => 'application.modules.backend.components.BClientScript'
        ),
        'request' => array(
            'class' => 'application.components.BHttpRequest',
            'enableCsrfValidation' => true
        ),
        'session' => array(
            'class' => 'application.components.BHttpSession'
        ),
        'user' => array(
            'class' => 'application.modules.backend.components.BWebUser',
            'allowAutoLogin' => true,
            'loginUrl' => array(
                'auth/auth/login'
            )
        ),
        'messages' => array(
            'class' => 'application.components.BDbMessageSource',
            'cacheID' => 'messCache'
        ),
        'mailer' => array(
            'class' => 'application.modules.backend.vendor.mailer.EMailer',
            'pathViews' => 'application.views.email',
            'pathLayouts' => 'application.views.email.layouts',
            'Mailer' => 'smtp'
        ),
        'urlManager' => array(
            'class' => 'application.modules.backend.components.BUrlManager',
            'urlFormat' => 'path',
            'showScriptName' => false,
            'cacheID' => 'urlCache'
        ),
        'contoller' => array(
        	'class' => 'application.modules.backend.components.BController'
        ),
        // generic cache
        'cache' => array(
            'class' => 'CMemCache',
            'keyPrefix' => 'b:app:backend:main',
            'useMemcached' => true,
            'servers'=>array(
                array(
                    'host'=>'127.0.0.1',
                    'port'=>11211
                )
            )
        ),
        // cms cache
        'cmsCache' => array(
            'class' => 'CMemCache',
            'keyPrefix' => 'b:app:cms',
            'useMemcached' => true,
            'servers'=>array(
                array(
                    'host'=>'127.0.0.1',
                    'port'=>11211
                )
            )
        ),
        // variable cache
        'varCache' => array(
            'class' => 'CMemCache',
            'keyPrefix' => 'b:app:var',
            'useMemcached' => true,
            'servers'=>array(
                array(
                    'host'=>'127.0.0.1',
                    'port'=>11211,
                )
            )
        ),
        // database cache
        'DBCache' => array(
            'class' => 'CMemCache',
            'keyPrefix' => 'b:app:db',
            'useMemcached' => true,
            'servers'=>array(
                array(
                    'host'=>'127.0.0.1',
                    'port'=>11211
                )
            )
        ),
        // rights cache
        'rightCache' => array(
            'class' => 'CMemCache',
            'keyPrefix' => 'b:app:backend:right',
            'useMemcached' => true,
            'servers'=>array(
                array(
                    'host'=>'127.0.0.1',
                    'port'=>11211,
                )
            )
        ),
        // messages cache
        'messCache' => array(
            'class' => 'CMemCache',
            'keyPrefix' => 'b:app:message',
            'useMemcached' => true,
            'servers'=>array(
                array(
                    'host'=>'127.0.0.1',
                    'port'=>11211
                )
            )
        ),
        // url rules cache
        'urlCache' => array(
            'class' => 'CMemCache',
            'useMemcached' => true,
            'keyPrefix' => 'b:app:backend:url',
            'servers'=>array(
                array(
                    'host'=>'127.0.0.1',
                    'port'=>11211
                )
            )
        ),
        // url rules cache
        'i18nCache' => array(
            'class' => 'CMemCache',
            'useMemcached' => true,
            'keyPrefix' => 'b:app:i18n',
            'servers'=>array(
                array(
                    'host'=>'127.0.0.1',
                    'port'=>11211
                )
            )
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