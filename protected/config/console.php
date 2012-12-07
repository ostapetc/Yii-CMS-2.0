<?
date_default_timezone_set('Europe/Moscow');

$config = ENV == 'install' ? 'main' : ENV;

$_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__ . '/../../') . DIRECTORY_SEPARATOR;

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
        'sphinx_conf'    => array(
            'class' => 'application.commands.SphinxConfCommand',
        ),
        'try'    => array(
            'class' => 'mma.commands.SherdogMediaParser',
        ),
        'parser_runner'    => array(
            'class' => 'content.commands.ParserRunnerCommand',
            'parsers' => array(
                array(
                    'class' =>  'content.commands.parsers.SherdogGalleryParser'
                )
            )
        ),
    ),
));
