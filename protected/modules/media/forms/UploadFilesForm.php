<?
return [
    'enctype'    => 'multipart/form-data',
    'action' => '/media/mediaAlbum/upload',
    'activeForm' => [
        'id'            => 'upload-album-form',
        'clientOptions' => [
            'validateOnSubmit' => true,
        ],
    ],
    'elements' => [
        'files' => [
            'type'      => 'uploader',
            'data_type' => 'image',
            'title'     => 'Файлы'
        ],
        'model_id' => [
            'type'  => 'hidden',
        ],
        'object_id' => [
            'type'  => 'hidden',
        ],
    ],
    'buttons'              => [
        'submit' => [
            'type'  => 'submit',
            'value' => t('сохранить'),
        ]
    ]
];
