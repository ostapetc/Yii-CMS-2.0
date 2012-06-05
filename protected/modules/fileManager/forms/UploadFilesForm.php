<?
return array(
    'enctype'    => 'multipart/form-data',
    'action' => '/fileManager/fileAlbum/upload',
    'activeForm' => array(
        'id'            => 'upload-album-form',
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ),
    'elements' => array(
        'files' => array(
            'type'      => 'file_manager',
            'tag'       => 'files',
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
