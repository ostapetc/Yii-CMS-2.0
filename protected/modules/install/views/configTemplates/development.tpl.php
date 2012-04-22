<?php

return array(
    'components' => array(
        'db' => array(
            'connectionString'      => 'mysql:%DB_HOST%=localhost;dbname=%DB_NAME%;',
            'emulatePrepare'        => true,
            'username'              => '%DB_LOGIN%',
            'password'              => '%DB_PASS%',
            'charset'               => 'utf8',
            'enableProfiling'       => true,
        )
    )
);
