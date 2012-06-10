<?
return CMap::mergeArray(require('main.php'), array(
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host=openserver;dbname=yiicms',
            'emulatePrepare'   => true,
            'username'         => 'mysql',
            'password'         => 'mysql',
            'charset'          => 'utf8',
            'enableProfiling'  => true,
        ),
    )
));