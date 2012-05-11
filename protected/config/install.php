<?
$conf = CMap::mergeArray(require ('main.php'), array(
    'components' => array(
        'installer' => array(
            'class' => 'install.components.SimpleCmsInstaller'
        ),
        'urlManager'=> array(
            'rules' => array(
                '' => 'install/install'
            )
        )
    ),
));

$conf['modules'] = array('install');

unset($conf['components']['authManager']);
unset($conf['onBeginRequest']);

return $conf;