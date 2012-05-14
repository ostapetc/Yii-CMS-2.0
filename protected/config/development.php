<?
return CMap::mergeArray(require('main.php'), array(
    'components' => array(
        'db' => array(
            'connectionString'      => 'mysql:localhost=localhost;dbname=yii_base;',
            'emulatePrepare'        => true,
            'username'              => 'root',
            'password'              => '',
            'charset'               => 'utf8',
            'enableProfiling'       => true,
        )
    )
));

