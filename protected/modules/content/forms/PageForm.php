<?
return [
    'enctype'              => 'multipart/form-data',
    'activeForm'           => [
        'id'            => 'page-form',
        'clientOptions' => ['validateOnSubmit' => true],
    ],
    'elements'             => [
        'title'    => [
            'type' => 'text'
        ],
//        'url' => [
//            'type'   => 'alias',
//            'source' => 'title'
//        ],
        'gallery'    => [
            'type'      => 'uploader_modal',
            'data_type' => 'image',
            'title'     => 'Файлы',
        ],
        'status'   => [
            'type'  => 'dropdownlist',
            'items' => Page::$status_options
        ],
        'tags'     => [
            'type'  => 'tags',
            'label' => 'Теги'
        ],
        'text'     => [
            'type' => 'editor'
        ],
    ],
    'buttons'              => [
        'submit' => [
            'type'  => 'submit',
            'value' => t('сохранить')
        ]
    ]
];
