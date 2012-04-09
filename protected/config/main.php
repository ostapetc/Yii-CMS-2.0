<?
$modules_includes = array();
$modules_dirs     = scandir(MODULES_PATH);

foreach ($modules_dirs as $module)
{
    if ($module[0] == ".") {
        continue;
    }

    $modules[] = $module;

    $modules_includes[] = "application.modules.{$module}.*";
    $modules_includes[] = "application.modules.{$module}.models.*";
    $modules_includes[] = "application.components.bootstrap.widgets.*";
    $modules_includes[] = "application.modules.{$module}.portlets.*";
    $modules_includes[] = "application.modules.{$module}.forms.*";
    $modules_includes[] = "application.modules.{$module}.components.*";
    $modules_includes[] = "application.modules.{$module}.components.zii.*";
    $modules_includes[] = "application.components.zii.gridColumns.*";
}

$modules['webshell'] = array(
    'class'        => 'ext.webshell.WebShellModule',
    'exitUrl'      => '/',
    'wtermOptions' => array(
        'PS1' => '%',
    ),
    'commands'       => array(
        'test' => array('js:function(){return "Hello, world!";}', 'Just a test.'),
    ),
    'ipFilters'      => array('*', '::1'),
    'yiicCommandMap' => array(
        'email'  => array(
            'class'=> 'ext.mailer.MailerCommand',
            'from' => 'www.pismeco@gmail.com',
        ),
        'migrate'=> array(
            'class'          => 'system.cli.commands.MigrateCommand',
            'migrationPath'  => 'application.components.migrations',
            'migrationTable' => 'tbl_migration',
            'connectionID'   => 'db',
            'templateFile'   => 'application.migrations.template',
            'interactive'    => false, //in web not define STDIN
        ),
    ),
);

$modules['gii'] = array(
    'class'          => 'system.gii.GiiModule',
    'generatorPaths' => array('application.components.gii'),
    'password'       => 'giisecret',
    'ipFilters'      => array(
        '127.0.0.1',
        '::1'
    )
);

return array(
    'language' => 'ru',
    'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'     => '',
    'preload'  => array('log'),
    'import'   => array_merge($modules_includes, array(
        'application.components.*',
        'application.components.Form',
        'application.components.validators.*',
        'application.components.zii.*',
        'application.components.formElements.*',
        'application.components.baseWidgets.*',
        'application.components.bootstrap.widgets.*',
        'application.libs.helpers.*',
        'ext.yiiext.filters.setReturnUrl.ESetReturnUrlFilter',
        'application.modules.srbac.controllers.SBaseController',
        'application.extensions.yiidebugtb.*',
    )),
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
        'log'=>array(
                'class'=>'CLogRouter',
                'routes'=>array(
//                    array(
//                        'class'        => 'DbLogRoute',
//                        'levels'       => 'error, warning, info',
//                        'connectionID' => 'db',
//                        'logTableName' => 'log',
//                        'enabled'      => true
//                    )
//                    array(
                           /*направляем результаты профайлинга в ProfileLogRoute (отображается
                           внизу страницы)*/
//                          'class'=>'CProfileLogRoute',
//                          'levels'=>'profile',
//                          'enabled'=>true,
//                    ),
                ),
        ),

        'cache' => array(
            'class'=>'system.caching.CFileCache',
        ),
    ),

    'onBeginRequest' => array('UrlManager', 'collectRules'),

    'params'         => array(
        'save_site_actions' => false,
        'multilanguage_support' => true,
        'collect_routes_form_modules' => true,
        'themes_enabled' => false
    )
);


