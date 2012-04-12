<?
return array(
    'enctype'    => 'multipart/form-data',
    'activeForm' => array(
        'id'            => 'page-form',
        'clientOptions' => array('validateOnSubmit' => true),
    ),
    'elements' => array(
        'title'    => array(
            'hint' => 'Это пример подсказки к элементу формы. Симпотично, удобно, ахуенно',
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
            'type'      => 'file_manager',
            'tag'       => 'a',
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

