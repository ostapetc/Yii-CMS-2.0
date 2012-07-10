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
//        'log'=>array(
//            'class'=>'CLogRouter',
//            'routes'=>array(
//                array(
//                    // направляем результаты профайлинга в ProfileLogRoute (отображается
//                    // внизу страницы)
//                    'class'=>'CProfileLogRoute',
//                    'levels'=>'profile',
//                    'enabled'=>true,
//                ),
//                array(
//                    'class'=>'ext.yiiDebugToolbar.YiiDebugToolbarRoute',
//                    'ipFilters'=>array('127.0.0.1'),
//                )
//            ),
//        ),
    )
));