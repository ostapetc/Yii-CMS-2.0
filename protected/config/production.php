<?

//return CMap::mergeArray(
//    require(dirname(__FILE__).'/main.php'),
//        array(
//        'components' => array(
//            'db' => array(
//		        'connectionString'       => 'mysql:host=openserver;dbname=yiicms;',
//		        'emulatePrepare'         => true,
//		        'username'                => 'root',
//		        'password'                => '7alla9icea',
//		        'charset'                 => 'utf8',
//                'schemaCachingDuration' => 86400,
//		        //'enableProfiling'  => true,
//	        )
//	    )
//    )
//);


return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'),
    array(
         'components' => array(
             'db' => array(
                 'connectionString'       => 'mysql:host=openserver;dbname=yiicms_2.0;',
                 'emulatePrepare'         => true,
                 'username'                => 'mysql',
                 'password'                => 'mysql',
                 'charset'                 => 'utf8',
                 'enableProfiling'        => true,
             )
         )
    )
);

