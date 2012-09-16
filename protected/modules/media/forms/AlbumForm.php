<?
return array(
    'action' => '/media/mediaAlbum/createUsers',
    'activeForm'           => array(
        'id'            => 'album-form',
    ),
    'elements'             => array(
        'title'    => array(
            'type' => 'text'
        ),
        'descr'    => array(
            'type'  => 'text',
        ),
        'files'    => array(
            'type'      => 'uploader',
            'data_type' => 'image',
            'title'     => 'Файлы'
        )
    ),
    'buttons'              => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => t('сохранить'),
        )
    )
);
