<?
$config = defined('ENV') ? ENV : CONFIG;
$config = $config == 'install' ? 'main' : $config;
return CMap::mergeArray(require($config . '.php'), array(
    'language'   => 'en',
    'commandMap' => array(
        'migrate'    => array(
            'class' => 'application.commands.ExtendMigrateCommand',
        ),
        'doc-block'    => array(
            'class' => 'ext.docBlock.DocBlockCommand',
            'config' => '2122'
        ),
    ),
));
