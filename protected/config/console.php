<?
return CMap::mergeArray(require(CONFIG . '.php'), array(
    'language'   => 'en',
    'commandMap' => array(
        'migrate'    => array(
            'class' => 'application.commands.ExtendMigrateCommand',
        ),
        'doc-block'    => array(
            'class' => 'ext.docBlock.DocBlockCommand',
        ),
    ),
));
