<?
$modules_includes = array();
$modules_dirs     = scandir(MODULES_PATH);

foreach ($modules_dirs as $module)
{
    if ($module[0] == ".") {
        continue;
    }

    $modules[] = $module;
}

return CMap::mergeArray(array(
    'language' => 'ru',
    'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'     => '',
    'preload'  => array('log'),
    'import'   => array(
        'application.components.*',
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
    'modules'    => $modules,
    'components' => array(
        'messages' => array(
            'class' => 'CDbMessageSource',
            'sourceMessageTable'     => 'languages_messages',
            'translatedMessageTable' => 'languages_translations'
        ),
        'bootstrap'=>array(
            'class'=>'application.components.bootstrap.components.Bootstrap'
        ),
        'assetManager' => array(
            'class' => 'AssetManager',
            'parsers' => array(
                'sass' => array( // key == the type of file to parse
                    'class' => 'ext.assetManager.Sass', // path alias to the parser
                    'output' => 'css', // the file type it is parsed to
                    'options' => array(
                        'syntax' => 'sass'
                    )
                ),
                'scss' => array( // key == the type of file to parse
                    'class' => 'ext.assetManager.Sass', // path alias to the parser
                    'output' => 'css', // the file type it is parsed to
                    'options' => array(
                        'syntax' => 'scss',
                        'style' => 'compressed'
                    )
                ),
                'less' => array( // key == the type of file to parse
                    'class' => 'ext.assetManager.Less', // path alias to the parser
                    'output' => 'css', // the file type it is parsed to
                    'options' => array(
                        'syntax' => 'scss',
                        'style' => 'compressed'
                    )
                ),
            ),
            'newDirMode'  => 0755,
            'newFileMode' => 0644
        ),
        'clientScript' => array(
            'class'    => 'CClientScript',
        ),
        'session'      => array(
//            'autoStart'=> true
        ),
        'user'         => array(
            'allowAutoLogin' => true,
            'class'          => 'WebUser'
        ),
        'metaTags'     => array(
            'class' => 'application.modules.main.components.MetaTags'
        ),
        'image'        => array(
            'class'  => 'application.extensions.image.CImageComponent',
            'driver' => 'GD'
        ),
        'dater'        => array(
            'class' => 'application.components.DaterComponent'
        ),
        'text'         => array(
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
        'urlManager'   => array(
            'urlFormat'      => 'path',
            'showScriptName' => false,
            'class'          => 'UrlManager'
        ),

        'errorHandler' => array(
            'errorAction' => 'main/main/error',
        ),

        'authManager'  => array(
            'class'           => 'CDbAuthManager',
            'connectionID'    => 'db',
            'itemTable'       => 'auth_items',
            'assignmentTable' => 'auth_assignments',
            'itemChildTable'  => 'auth_items_childs',
            'defaultRoles'    => array('guest')
        ),
//        'log'=>array(
//                'class'=>'CLogRouter',
//                'routes'=>array(
//                    array(
//                        'class'        => 'DbLogRoute',
//                        'levels'       => 'error, warning, info',
//                        'connectionID' => 'db',
//                        'logTableName' => 'log',
//                        'enabled'      => true
//                    ),
//                    array(
//                           /*направляем результаты профайлинга в ProfileLogRoute (отображается
//                           внизу страницы)*/
//                          'class'=>'CProfileLogRoute',
//                          'levels'=>'profile',
//                          'enabled'=>true,
//                    ),
//                ),
//        ),
//        'log'=>array(
//                'class'=>'CLogRouter',
//                'routes'=>array(
//                    array(
//                        'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
//                        'ipFilters'=>array('127.0.0.1','192.168.1.215'),
//                    ),
//                ),
//            ),


        'cache' => array(
            'class'=>'system.caching.CFileCache',
        ),
    ),

    'onBeginRequest' => array('AppManager', 'init'),


    'params'         => array(
        'save_site_actions' => true,
        'multilanguage_support' => true,
        'collect_routes_from_modules' => true,
        'themes_enabled' => false
    )
), require (ENV.'.php'));


