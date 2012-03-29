<?php

return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'),
        array(
        'components' => array(
            'db' => array(
		        'connectionString'      => 'mysql:host=localhost;dbname=yiicms_2.0;',
		        'emulatePrepare'        => true,
		        'username'              => 'root',
		        'password'              => '1',
		        'charset'               => 'utf8',
                'schemaCachingDuration' => 86400,
		        //'enableProfiling'  => true, 
	        )
	    ) 
    )
);



