<?
$config = defined('ENV') ? ENV : CONFIG;
$config = $config == 'install' ? 'main' : $config;
return CMap::mergeArray(require($config . '.php'), array(
    'language'   => 'en',
    'commandMap' => array(
        'migrate'    => array(
            'class' => 'application.commands.ExtendMigrateCommand',
        ),
        'doc_block'    => array(
            'class' => 'ext.docBlock.DocBlockCommand',
        ),
        'remote_upload'    => array(
            'class' => 'media.commands.RemoteUploadCommand',
        ),
    ),
));
