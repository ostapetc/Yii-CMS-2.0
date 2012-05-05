<?php
return CMap::mergeArray(require ('main.php'), array(
    'components' => array(
        'db' => array(
            'connectionString'      => 'mysql:host=%DB_HOST%;dbname=%DB_NAME%;',
            'emulatePrepare'        => true,
            'username'              => '%DB_LOGIN%',
            'password'              => '%DB_PASS%',
            'charset'               => 'utf8',
            'enableProfiling'       => true,
        ),
        // 'log'=>array(
//                'class'=>'CLogRouter',
//                'routes'=>array(
//                    array(
//                        'class'        => 'DbLogRoute',
//                        'levels'       => 'error, warning, info',
//                        'connectionID' => 'db',
//                        'logTableName' => 'log',
//                        'enabled'      => true
//                    ),
//                    array(
//                           /*направляем результаты профайлинга в ProfileLogRoute (отображается
//                           внизу страницы)*/
//                          'class'=>'CProfileLogRoute',
//                          'levels'=>'profile',
//                          'enabled'=>true,
//                    ),
//                ),
//        ),
    )
));

