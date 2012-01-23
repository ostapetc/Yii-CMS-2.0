<?php
$packages = array(
    'debug'           => array(
        'baseUrl' => 'js/packages/debug/',
        'js'      => array(
            'debug.js',
        ),
        'depends' => array('jquery')
    ),
    'clientForm'      => array(
        'baseUrl' => 'js/packages/clientForm/',
        'js'      => array(
            'grewForm/grewForm.js',
            'tipInput/tipinput.js',
            'inFieldLabel/jquery.infieldlabel.js',
            'clientForm.js',
        ),
        'css'     => array('form.css'),
        'depends' => array('jquery')
    ),
    'adminBaseClasses'=> array(
        'baseUrl' => 'js/packages/adminBaseClasses',
        'js'      => array(
            'buttonSet.js',
            'gridBase.js'
        ),
        'depends' => array(
            'jquery',
            'jquery.ui'
        )
    ),

);

return $packages;