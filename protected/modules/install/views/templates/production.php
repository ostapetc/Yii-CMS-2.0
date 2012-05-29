<?php
return CMap::mergeArray(require ('main.php'), array(
     'components' => array(
         'db' => array(
             'connectionString'      => 'mysql:host={{DB_HOST}};dbname={{DB_NAME}};',
             'emulatePrepare'        => true,
             'username'              => '{{DB_LOGIN}}',
             'password'              => '{{DB_PASS}}',
             'charset'               => 'utf8',
             'enableProfiling'       => true,
         ),
     )
));

