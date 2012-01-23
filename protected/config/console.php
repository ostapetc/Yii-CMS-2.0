<?php

define('PROTECTED_PATH', realpath(dirname(__FILE__) . '/../../protected/') . '/');
define('MODULES_PATH', PROTECTED_PATH . 'modules/');
define('LIBRARY_PATH', PROTECTED_PATH . 'libs/');
define('WEB_PATH', 'http://el.korolevsait.ru/');

$modules_includes = array();
$modules_dirs     = scandir(MODULES_PATH);

foreach ($modules_dirs as $module)
{
    if ($module[0] == '.') continue;

    $modules[] = $module;

    $modules_includes[] = 'application.modules.{$module}.*';
    $modules_includes[] = 'application.modules.{$module}.models.*';
    $modules_includes[] = 'application.modules.{$module}.portlets.*';
    $modules_includes[] = 'application.modules.{$module}.forms.*';
    $modules_includes[] = 'application.modules.{$module}.components.*';
}



return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',

	'import'=> array_merge(
        $modules_includes,
        array(
            'application.components.*',
            'application.libs.tools.*',
            'ext.yiiext.filters.setReturnUrl.ESetReturnUrlFilter',
            'application.modules.srbac.controllers.SBaseController',
	    )
    ),
    'modules' => $modules,
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=elpolis_ci;',
            'emulatePrepare'   => true,
            'username'         => 'elpolis',
            'password'         => 'EPdEUoTn',
            'charset'          => 'utf8',
            //'enableProfiling'  => true,
        )
    )
);