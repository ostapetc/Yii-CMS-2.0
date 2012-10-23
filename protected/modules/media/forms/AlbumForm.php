<?
return [
    'action' => '/media/mediaAlbum/createUsers',
    'activeForm'           => [
        'id'            => 'album-form',
    ],
    'elements'             => [
        'title'    => [
            'type' => 'text'
        ],
        'descr'    => [
            'type'  => 'text',
        ],
    ],
    'buttons'              => [
        'submit' => [
            'type'  => 'submit',
            'value' => t('сохранить'),
        ]
    ]
];