<?
return array(
    'enctype'    => 'multipart/form-data',
    'activeForm' => array(
        'id'            => 'page-form',
        'clientOptions' => array('validateOnSubmit' => true),
    ),
    'elements' => array(
        'title'    => array(
            'type' => 'text'
        ),
//        'url' => array(
//            'type'   => 'alias',
//            'source' => 'title'
//        ),
        'status' => array(
            'type'  => 'dropdownlist',
            'items' => Page::$status_options
        ),
        'text' => array(
            'type' => 'editor'
        ),
        'tags' => array(
            'type'  => 'TagsInput',
            'label' => 'Теги'
        ),
        'gallery' => array(
            'type'      => 'file_manager',
            'tag'       => 'gallery',
            'data_type' => 'image',
            'title'     => 'Файлы'
        )
    ),
    'buttons'              => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => t('сохранить')
        )
    )
);
