<?
return array(
    'enctype'    => 'multipart/form-data',
    'action' => '/media/mediaAlbum/create',
    'activeForm' => array(
        'id'            => 'album-form',
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ),
    'elements' => array(
        'title'    => array(
            'type' => 'text'
        ),
        'descr' => array(
            'type'  => 'text',
        ),
        'model_id' => array(
            'type'  => 'hidden',
        ),
        'object_id' => array(
            'type'  => 'hidden',
        ),
    ),
    'buttons'              => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => t('сохранить'),
        )
    )
);
