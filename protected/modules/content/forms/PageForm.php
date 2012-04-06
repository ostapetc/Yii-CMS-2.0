<?
return array(
    'activeForm'           => array(
        'id'                   => 'page-form',
        'enableAjaxValidation' => true,
        'clientOptions'        => array('validateOnSubmit'=> true),
    ),
    'enctype'              => 'multipart/form-data',
    'elements'             => array(
        'title'        => array(
            'type' => 'text'
        ),
        'url'          => array(
            'type'   => 'alias',
            'source' => 'title'
        ),
        'is_published' => array(
            'type' => 'checkbox'
        ),
        'text'         => array(
            'type' => 'editor'
        ),
        'meta_tags'    => array(
            'type' => 'meta_tags'
        ),
        'file_manager' => array(
            'type'=>'file_manager',
            'tag'=>'a',
            'data_type' => 'image'
        )
    ),
    'buttons'              => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => t('сохранить')
        )
    )
);

