<?
$modules_includes = [];
$modules_dirs     = scandir(MODULES_PATH);

foreach ($modules_dirs as $module)
{
    if ($module[0] == ".")
    {
        continue;
    }

    $modules[] = $module;
}

return [
    'language'       => 'ru',
    'basePath'       => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name'           => '',
    'preload'        => ['log'],
    'import'         => [
        'application.components.*',
        'application.components.interfaces.*',
        'application.components.Form',
        'application.components.validators.*',
        'application.components.zii.*',
        "application.components.zii.gridColumns.*",
        'application.components.formElements.*',
        'application.components.baseWidgets.*',
        'application.components.bootstrap.widgets.*',
        'application.components.activeRecordBehaviors.*',
        'application.libs.helpers.*',
        'application.extensions.yiidebugtb.*',
    ],
    'modules'        => $modules,
    'components'     => [
        'executor'     => [
            'class' => 'application.components.CommandExecutor',
        ],
        'messages'     => [
            'class'                  => 'CDbMessageSource',
            'sourceMessageTable'     => 'languages_messages',
            'translatedMessageTable' => 'languages_translations'
        ],
        'bootstrap'    => [
            'class' => 'application.components.bootstrap.components.Bootstrap'
        ],
        'search'       => [
            'class'             => 'ext.sphinx.SphinxSearch',
            'server'            => '127.0.0.1',
            'port'              => 9312,
            'maxQueryTime'      => 3000,
            'enableProfiling'   => 0,
            'enableResultTrace' => 0,
        ],
        'assetManager' => [
            'class'       => 'CAssetManager',
            'newDirMode'  => 0755,
            'newFileMode' => 0644
        ],
        'clientScript' => [
            'class' => 'ClientScript',
        ],
        'session'      => [
            'autoStart' => true
        ],
        'user'         => [
            'allowAutoLogin' => true,
            'class'          => 'WebUser'
        ],
        'metaTags'     => [
            'class' => 'application.modules.main.components.MetaTags'
        ],
        'image'        => [
            'class'  => 'application.extensions.image.CImageComponent',
            'driver' => 'GD'
        ],
        'dater'        => [
            'class' => 'application.components.DaterComponent'
        ],
        'text'         => [
            'class' => 'application.components.TextComponent'
        ],
        'request'      => [
            'class'                  => 'HttpRequest',
            'enableCsrfValidation'   => false,
            'noCsrfValidationRoutes' => [
                '^services/api/soap.*$',
                '^services/api/json.*$',
            ],
            'csrfTokenName'          => 'token',
        ],
        'urlManager'   => [
            'urlFormat'      => 'path',
            'showScriptName' => false,
            'class'          => 'UrlManager'
        ],
        'errorHandler' => [
            'class'       => 'CErrorHandler',
            'errorAction' => 'main/main/error',
        ],
        'authManager'  => [
            'class'           => 'CDbAuthManager',
            'connectionID'    => 'db',
            'itemTable'       => 'auth_items',
            'assignmentTable' => 'auth_assignments',
            'itemChildTable'  => 'auth_items_childs',
            'defaultRoles'    => ['guest']
        ],
        'cache'        => [
            'class' => 'system.caching.CFileCache',
        ],
        'log'          => [
            'class'  => 'CLogRouter',
            'routes' => [
                [
                    'class'        => 'CDbLogRoute',
                    'levels'       => 'info, error, warning',
                    'connectionID' => 'db',
                    'logTableName' => 'log'
                ],
                /*
                [
                    'class' => 'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
                    'ipFilters' => ['*'),
                ]
                /**/
            ],
        ],
    ],
    'onBeginRequest' => [
        'AppManager',
        'init'
    ],

    'params'         => [
        'save_site_actions'           => true,
        'multilanguage_support'       => false,
        'collect_routes_from_modules' => true,
        'themes_enabled'              => false
    ]
];
