<?php

return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'),
        array(
        'components' => array(
            'db' => array(
		        'connectionString' => 'mysql:host=u185386.mysql.masterhost.ru;dbname=u185386_self;',
		        'emulatePrepare'   => true,
		        'username'         => 'u185386_self',
		        'password'         => '7alla9icea',
		        'charset'          => 'utf8',
                'schemaCachingDuration' => 86400,
		        //'enableProfiling'  => true, 
	        )
	    ) 
    )
);

