<?

define('DS', DIRECTORY_SEPARATOR);

require_once dirname(__FILE__) . DS . 'constants.php';


$modules_includes = array();
$modules_dirs     = scandir(MODULES_PATH);

foreach ($modules_dirs as $module)
{
    if ($module[0] == ".") {
        continue;
    }

    $modules[] = $module;
}

return array(
	'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'     => 'Console Application',
    'import'   => array(
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
    'modules'    => $modules,
	'components' => array(
        'db' => array(
            'connectionString'      => 'mysql:host=openserver;dbname=yiicms_2.0;',
            'emulatePrepare'        => true,
            'username'              => 'mysql',
            'password'              => 'mysql',
            'charset'               => 'utf8',
            'enableProfiling'       => true,
        )
	),
);