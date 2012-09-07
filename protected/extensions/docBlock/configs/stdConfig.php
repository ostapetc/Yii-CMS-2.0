<?php
return array(
    //change it if you would process some other files
    'filesIterator'           => 'ModelInModuleFilesIterator',
    //change it if you would scope only some specific classes, based on this
    'baseClass'               => 'CComponent',
    //iterator by object properties, you can hide some set
    'propertyIteratorOptions' => array(
        'class'                   => 'YiiComponentPropertyIterator',
        'commentLanguage'         => 'ru',
        'commentCategory'         => 'core',
        'addIllustrationCommetns' => true,
        'includeAttributes'       => true,
        'includeEvents'           => false,
        'includeAccessors'        => true,
        'includeRelations'        => true
    ),
    //some settings for @property annotation
    'propertyOptions'         => array(
        'class'                     => 'YiiComponentProperty',
        'toUndercore'               => false,
        'readWriteDifferentiate'    => false, //use or not @property-write/@property-read annotations
        'tagVerticalAlignment'      => true,
        'typeVerticalAlignment'     => true,
        'propertyVerticalAlignment' => true
    ),
    //some settings for @method annotation
    'methodOptions'           => array(
        'class'                     => 'YiiComponentMethod',
        'toUndercore'               => false,
        'tagVerticalAlignment'      => true,
        'typeVerticalAlignment'     => true,
        'propertyVerticalAlignment' => true
    )
);