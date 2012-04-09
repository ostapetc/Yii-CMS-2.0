<?php

return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'),
        array(
        'components' => array(
            'db' => array(
		        'connectionString' => 'mysql:host=openserver;dbname=yiicms_2.0;',
		        'emulatePrepare'   => true,
		        'username'         => 'mysql',
		        'password'         => 'mysql',
		        'charset'          => 'utf8',
		        //'enableProfiling'  => true,
	        )
	    ) 
    )
);



