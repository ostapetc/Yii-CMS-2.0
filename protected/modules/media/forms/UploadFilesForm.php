<?
return array(
    'enctype'    => 'multipart/form-data',
    'action' => '/media/mediaAlbum/upload',
    'activeForm' => array(
        'id'            => 'upload-album-form',
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ),
    'elements' => array(
        'files' => array(
            'type'      => 'file_uploader',
            'data_type' => 'image',
            'title'     => 'Файлы'
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
