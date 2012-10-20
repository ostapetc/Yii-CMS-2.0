<?php
return [
    [
        'actions'  => ['view'],
        'sidebars' => [
            [
                'type' => 'widget',
                'class' => 'media.portlets.MediaAlbumList',
                'user'  => Yii::app()->controller->user
            ],
            [
                'type' => 'widget',
                'class' => 'media.portlets.MediaAlbumList',
                'user'  => new User
            ],
        ]
    ],
];
