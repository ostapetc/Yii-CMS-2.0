<?
return array(
    'activeForm'           => array(
        'id'                   => 'page-form',
        'clientOptions'        => array('validateOnSubmit'=> true),
    ),
    'enctype'              => 'multipart/form-data',
    'elements'             => array(
        'title'        => array(
            'hint' => 'Это пример подсказки к элементу формы. Достаточно симпотично и удобно',
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
    ),
    'buttons'              => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => t('сохранить')
        )
    )
);

