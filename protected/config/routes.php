<?php
return array(
    ''                                                      => 'content/page/main',
    '<lang:[a-z]{2}>'                                       => 'content/page/main',
    '<lang:[a-z]{2}>/page/<id:\d+>'                         => 'content/page/view',
    '<lang:[a-z]{2}>/page/<url:.*>'                         => 'content/page/view',

    'admin'                                                 => 'main/mainAdmin',
    '<lang:[a-z]{2}>/search'                                => 'main/main/search',
    '<lang:[a-z]{2}>/feedback'                              => 'main/feedback/create',

    '<lang:[a-z]{2}>/login'                                 => 'users/user/login',
    '<lang:[a-z]{2}>/logout'                                => 'users/user/logout',
    '<lang:[a-z]{2}>/registration'                          => 'users/user/registration',
    '<lang:[a-z]{2}>/activateAccount/<code:.*>/<email:.*>'  => 'users/user/activateAccount',
    '<lang:[a-z]{2}>/activateAccountRequest'                => 'users/user/activateAccountRequest',
    '<lang:[a-z]{2}>/changePasswordRequest'                 => 'users/user/changePasswordRequest',
    '<lang:[a-z]{2}>/changePassword/<code:.*>/<email:.*>'   => 'users/user/changePassword',
    'admin/login'                                           => 'users/userAdmin/login',

    '<lang:[a-z]{2}>/news/<id:\d+>'                         => 'news/news/view',
    '<lang:[a-z]{2}>/news'                                  => 'news/news/index',

    '<lang:[a-z]{2}>/<controller:\w+>/<id:\d+>'             => '<controller>/view',
    '<lang:[a-z]{2}>/<controller:\w+>/<action:\w+>/<id:\d+>'=> '<controller>/<action>',
    '<lang:[a-z]{2}>/<controller:\w+>/<action:\w+>'         => '<controller>/<action>',
    '<controller:\w+>/<id:\d+>'                             => '<controller>/view',
    '<controller:\w+>/<action:\w+>/<id:\d+>'                => '<controller>/<action>',
    '<controller:\w+>/<action:\w+>'                         => '<controller>/<action>',
);