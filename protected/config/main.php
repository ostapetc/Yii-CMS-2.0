<?
$modules_includes = array();
$modules_dirs = scandir(MODULES_PATH);

foreach ($modules_dirs as $module)
{
    if ($module[0] == ".")
    {
        continue;
    }

    $modules[] = $module;
}

return array(
    'language' => 'ru',
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => '',
    'preload' => array('log'),
    'import' => array(
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
    ),
    'modules' => $modules,
    'components' => array(
        'executor' => array(
            'class' => 'application.components.CommandExecutor',
        ),
        'messages' => array(
            'class' => 'CDbMessageSource',
            'sourceMessageTable' => 'languages_messages',
            'translatedMessageTable' => 'languages_translations'
        ),
        'bootstrap' => array(
            'class' => 'application.components.bootstrap.components.Bootstrap'
        ),
        'assetManager' => array(
            'class' => 'CAssetManager',
            'newDirMode' => 0755,
            'newFileMode' => 0644
        ),
        'clientScript' => array(
            'class' => 'ClientScript',
        ),
        'session' => array(
            'autoStart' => true
        ),
        'user' => array(
            'allowAutoLogin' => true,
            'class' => 'WebUser'
        ),
        'metaTags' => array(
            'class' => 'application.modules.main.components.MetaTags'
        ),
        'image' => array(
            'class' => 'application.extensions.image.CImageComponent',
            'driver' => 'GD'
        ),
        'dater' => array(
            'class' => 'application.components.DaterComponent'
        ),
        'text' => array(
            'class' => 'application.components.TextComponent'
        ),
        'request' => array(
            'class' => 'HttpRequest',
            'enableCsrfValidation' => false,
            'noCsrfValidationRoutes' => array(
                '^services/api/soap.*$',
                '^services/api/json.*$',
            ),
            'csrfTokenName' => 'token',
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'class' => 'UrlManager'
        ),
        'errorHandler' => array(
            'class' => 'CErrorHandler',
            'errorAction' => 'main/main/error',
        ),
        'authManager' => array(
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
            'itemTable' => 'auth_items',
            'assignmentTable' => 'auth_assignments',
            'itemChildTable' => 'auth_items_childs',
            'defaultRoles' => array('guest')
        ),
        'cache' => array(
            'class' => 'system.caching.CFileCache',
        ),
        'log' => array(
            'class'  => 'CLogRouter',
            'routes' => array(
                array(
                    'class'        => 'CDbLogRoute',
                    'levels'       => 'info, error, warning',
                    'connectionID' => 'db',
                    'logTableName' => 'log'
                )
                /*array(
                    'class' => 'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
                    'ipFilters' => array('*'),
                )*/
            ),
        ),
    ),
    'onBeginRequest' => array('AppManager', 'init'),

    'params'         => array(
        'save_site_actions' => true,
        'multilanguage_support' => false,
        'collect_routes_from_modules' => true,
        'themes_enabled' => false
    )
);
