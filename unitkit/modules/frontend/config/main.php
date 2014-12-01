<?php
// Application path
Yii::setPathOfAlias('application', dirname(__FILE__) . '/../../..');

// CWebApplication properties can be configured here.
return array(
    // application ID (should be unique)
    'id' => '',
    'name' => 'Frontend',
    'basePath' => Yii::getPathOfAlias('application'),
    'preload' => array(
        'log'
    ),
    // autoloading model and component classes
    'import' => array(
        'application.components.*',
        'application.components.dataView.*',
        'application.models.*',
        'application.modules.frontend.models.*',
        'application.modules.frontend.components.*',
        'application.modules.frontend.vendor.EScriptBoost.*'
    ),
    // default language
    'language' => 'fr',
    // list of activated modules
    // !! module order is very important because url rules of modules are evaluated in statement order) !!
    // !! cms module should be declared at the end!!
    'modules' => array(
        'frontend' => array(
            'albumPhotoUrlDest' => '//static.unitkit.local/cms/albums',
            'modules' => array(
                'site',
                'contact',
                'news',
                'cms',
            )
        )
    ),
    // application components
    'components' => array(
        'variables' => array(
            'class' => 'application.components.BDbVariable',
            'cacheID' => 'varCache'
        ),
        'rights' => array(
            'class' => 'application.components.BDbRight',
            'cacheID' => 'rightCache'
        ),
        'mail' => array(
            'class' => 'application.modules.frontend.components.BMail',
            'classFunction' => 'BMailFunction'
        ),
        'clientScript' => array(
            'class' => 'application.modules.frontend.components.BClientScript'
        ),
        'request' => array(
            'class' => 'application.components.BHttpRequest',
            'enableCsrfValidation' => true
        ),
        'session' => array(
            'class' => 'application.components.BHttpSession'
        ),
        'messages' => array(
            'class' => 'application.components.BDbMessageSource',
            'cacheID' => 'messCache'
        ),
        'mailer' => array(
            'class' => 'application.modules.frontend.vendor.mailer.EMailer',
            'pathViews' => 'application.views.email',
            'pathLayouts' => 'application.views.email.layouts',
            // See phpmailer documentation
            'Mailer' => 'smtp',
            //'Host' => ''
        ),
        'urlManager' => array(
            'class' => 'application.modules.frontend.components.BUrlManager',
            'urlFormat' => 'path',
            'showScriptName' => false,
            'cacheID' => 'urlCache'
        ),
        // generic cache
        'cache' => array(
            'class' => 'CMemCache',
            'useMemcached' => true,
            'keyPrefix' => 'b:app:frontend:main'
        ),
        // cms cache
        'cmsCache' => array(
            'class' => 'CMemCache',
            'useMemcached' => true,
            'keyPrefix' => 'b:app:cms'
        ),
        // variable cache
        'varCache' => array(
            'class' => 'CMemCache',
            'useMemcached' => true,
            'keyPrefix' => 'b:app:var'
        ),
        // database cache
        'DBCache' => array(
            'class' => 'CMemCache',
            'useMemcached' => true,
            'keyPrefix' => 'b:app:db'
        ),
        // messages cache
        'messCache' => array(
            'class' => 'CMemCache',
            'useMemcached' => true,
            'keyPrefix' => 'b:app:message'
        ),
        // url rules cache
        'urlCache' => array(
            'class' => 'CMemCache',
            'useMemcached' => true,
            'keyPrefix' => 'b:app:frontend:url'
        ),
        // url rules cache
        'i18nCache' => array(
            'class' => 'CMemCache',
            'useMemcached' => true,
            'keyPrefix' => 'b:app:i18n'
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
            'errorAction' => 'frontend/site/site/error'
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
                    'enabled' => YII_DEBUG
                )
            )
        )
    ),
    'params' => array(
        'baseModuleApplication' => 'frontend'
    )
);