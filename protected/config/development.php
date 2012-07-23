<?
return array_merge_recursive(require('main.php'), array(
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=cms2',
            'emulatePrepare'   => true,
            'username'         => 'root',
            'password'         => '',
            'charset'          => 'utf8',
            'enableProfiling'  => true,
        ),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    // направляем результаты профайлинга в ProfileLogRoute (отображается
                    // внизу страницы)
                    'class'=>'CProfileLogRoute',
                    'levels'=>'profile',
                    'enabled'=>true,
                ),
//                array(
//                    'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
//                    'ipFilters'=>array('127.0.0.1'),
//                )
            ),
        ),
    )
));
