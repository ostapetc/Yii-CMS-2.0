<?
$conf = CMap::mergeArray(require ('main.php'), array(
    'preload'  => array('bootstrap'),
    'components' => array(
        'installer' => array(
            'class' => 'install.components.SimpleCmsInstaller'
        ),
        'urlManager'=> array(
            'rules' => array(
                '' => 'install/install'
            )
        ),
    ),
    'modules' => array('install'),
    'onBeginRequest' => function($event) {
        $assets = Yii::getPathOfAlias('webroot.assets');
        $runtime = Yii::getPathOfAlias('application.runtime');
        try {
            is_dir($assets) or (@mkdir($assets, 0755));
            is_dir($runtime) or (@mkdir($runtime, 0755));
        } catch (Exception $e) {}
    }
));
unset($conf['components']['authManager']);
unset($conf['components']['log']);
unset($conf['components']['cache']);
return $conf;