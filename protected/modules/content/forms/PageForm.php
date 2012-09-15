<?
return array(
    'enctype'              => 'multipart/form-data',
    'activeForm'           => array(
        'id'            => 'page-form',
        'clientOptions' => array('validateOnSubmit' => true),
    ),
    'elements'             => array(
        'title'    => array(
            'type' => 'text'
        ),
//        'url' => array(
//            'type'   => 'alias',
//            'source' => 'title'
//        ),
        'gallery'    => array(
            'type'      => 'uploader_modal',
            'data_type' => 'image',
            'title'     => 'Файлы'
        ),
        'status'   => array(
            'type'  => 'dropdownlist',
            'items' => Page::$status_options
        ),
        'tags'     => array(
            'type'  => 'tags',
            'label' => 'Теги'
        ),
        'text'     => array(
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
