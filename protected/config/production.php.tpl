<?
return CMap::mergeArray(require('main.php'), array(
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname={{mysql.db.name}}',
            'emulatePrepare'   => true,
            'username'         => '{{mysql.user}}',
            'password'         => '{{mysql.pass}}',
            'charset'          => 'utf8',
            'enableProfiling'  => true,
        ),
        'log'=>array(
            'class'=>'CLogRouter',
        ),
    )
));