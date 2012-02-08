<?php
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
    $modules_includes[] = "application.modules.{$module}.portlets.*";
    $modules_includes[] = "application.modules.{$module}.forms.*";
    $modules_includes[] = "application.modules.{$module}.components.*";
    $modules_includes[] = "application.modules.{$module}.components.zii.*";
}


$modules['webshell'] = array(
    'class'          => 'ext.webshell.WebShellModule',
    // when typing 'exit', user will be redirected to this URL
    'exitUrl'        => '/',
    // custom wterm options
    'wtermOptions'   => array(
        // linux-like command prompt
        'PS1' => '%',
    ),
    // additional commands (see below)
    'commands'       => array(
        'test' => array('js:function(){return "Hello, world!";}', 'Just a test.'),
    ),
    // uncomment to disable yiic
    // 'useYiic' => false,

    // adding custom yiic commands not from protected/commands dir
    'ipFilters'      => array('*', '::1'),
    'yiicCommandMap' => array(
        'email'  => array(
            'class'=> 'ext.mailer.MailerCommand',
            'from' => 'www.pismeco@gmail.com',
        ),
        'migrate'=> array(
            'class'          => 'system.cli.commands.MigrateCommand',
            'migrationPath'  => 'application.migrations',
            'migrationTable' => 'tbl_migration',
            'connectionID'   => 'db',
            'templateFile'   => 'application.migrations.template',
            'interactive'    => false, //in web not define STDIN
        ),
    ),
);

$modules['gii'] = array(
    'class'          => 'system.gii.GiiModule',
    'generatorPaths' => array('application.gii'),
    'password'       => 'giisecret',
    'ipFilters'      => array(
        '127.0.0.1',
        '::1'
    )
);

return array(
    'language'   => 'ru',
    'basePath'   => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'       => '',
    'preload'      => array('log', 'bootstrap'),
    'import'     => array_merge($modules_includes, array(
            'application.components.*',
            'application.components.validators.*',
            'application.components.zii.*',
            'application.components.formElements.*',
            'application.components.baseWidgets.*',
            'application.libs.tools.*',
            'ext.yiiext.filters.setReturnUrl.ESetReturnUrlFilter',
            'application.modules.srbac.controllers.SBaseController',
        )),

    'modules'    => $modules,

    'components' => array(
        'bootstrap'=>array(
            'class'=>'application.components.bootstrap.components.Bootstrap'
        ),
        'assetManager' => array(
            'class'       => 'CAssetManager',
            'newDirMode'  => 0755,
            'newFileMode' => 0644
        ),
        'clientScript' => array(
            'class'    => 'CClientScript',
        ),
        'session'      => array(
            'autoStart'=> true
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
//                    )
//                ),
//        ),

        'cache' => array(
            'class'=>'system.caching.CFileCache',
        ),
    ),

    'onBeginRequest' => array('UrlManager', 'collectRules'),

    'params'     => array(
        'save_site_actions' => false
    )
);

