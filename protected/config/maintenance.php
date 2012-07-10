<?
return CMap::mergeArray(require('main.php'), array(
    'preload' => array('log', 'maintenanceMode'),
    'components' => array(
        'maintenanceMode' => array(
            'class' => 'application.extensions.MaintenanceMode.MaintenanceMode',
            'enabledMode' => true,
            'message' => 'У нас перерыв 5 минут на улучшение сайта',
            'users' => array(),
            'roles' => array(),
            'ips' => array(),
        ),
    )
));