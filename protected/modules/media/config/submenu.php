<?php
return [
    [
        'label' => t('Ваши альбомы'),
        'url'   => ['/media/mediaAlbum/manage', 'user_id' => Yii::app()->user->id]
    ],
    [
        'label' => t('Ваши видео'),
        'url'   => ['/media/mediaVideo/manage', 'user_id' => Yii::app()->user->id]
    ],
];