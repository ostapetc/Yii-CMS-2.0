<?
return CMap::mergeArray(require('main.php'), array(
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=cms2',
            'emulatePrepare'   => true,
            'username'         => 'root',
            'password'         => '',
            'charset'          => 'utf8',
            'enableProfiling'  => true,
        )
    )
));

