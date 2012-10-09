<?
return CMap::mergeArray(require('main.php'), array(
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname={{mysql.db.name}}',
            'emulatePrepare'   => true,
            'username'         => '{{mysql.user}}',
            'password'         => '{{mysql.pass}}',
            'charset'          => 'utf8',
            'enableProfiling'  => true,
        ),
        'log'=> array(
            'class'=> 'CLogRouter',
        ),
    ),
    'params'     => array(
        'youTube'   => array(
            'app'  => '{{youtube.app}}',
            'key'  => '{{youtube.key}}',
            'user' => '{{youtube.user}}',
            'pass' => '{{youtube.pass}}'
        ),
        'vkontakte' => array(
            'app' => '{{vk.app}}',
            'key'    => '{{vk.key}}',
        )
    )

));