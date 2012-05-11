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
        'url' => array(
            'type'   => 'alias',
            'source' => 'title'
        ),
        'status' => array(
            'type'  => 'dropdownlist',
            'items' => Page::$status_options
        ),
        'tags' => array(
            'type'  => 'TagsInput',
            'label' => 'Теги'
        ),
        'text' => array(
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
