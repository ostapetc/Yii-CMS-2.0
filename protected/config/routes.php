<?php
return array(
    '<language:(en|ru)>/<route:[\w\/]+>'       => '<route>',
    ''                                        => 'content/page/main',
    '/page/<id:\d+>'                          => 'content/page/view',
    '/page/<url:.*>'                          => 'content/page/view',
    'docs/<view>'                             => 'docs/mark/index',
    'docs/<folder>/<view>'                    => 'docs/mark/index',

    '/admin'                                  => 'main/mainAdmin',
    '/admin/login'                            => 'users/userAdmin/login',

    '/search'                                 => 'main/main/search',
    '/feedback'                               => 'main/feedback/create',

    '/login'                                  => 'users/user/login',
    '/logout'                                 => 'users/user/logout',
    '/logout'                                                => 'users/user/logout',
    '/registration'                           => 'users/user/registration',
    '/activateAccount/<code:.*>/<email:.*>'   => 'users/user/activateAccount',
    '/activateAccountRequest'                 => 'users/user/activateAccountRequest',
    '/changePasswordRequest'                  => 'users/user/changePasswordRequest',
    '/changePassword/<code:.*>/<email:.*>'    => 'users/user/changePassword',

    '/news/<id:\d+>'                          => 'news/news/view',
    '/news'                                   => 'news/news/index',

    '/<controller:\w+>/<id:\d+>'              => '<controller>/view',
    '/<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
    '/<controller:\w+>/<action:\w+>'          => '<controller>/<action>',
    '<language:(en|ru)>/<route:[w\/]+>'       => '<route>'
);