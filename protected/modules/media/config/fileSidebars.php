<?php
return [
    [
        'actions'  => ['manage'],
        'sidebars' => [
            'widget' => [
                'class' => 'media.portlets.MediaAlbumList',
                'is_my' => function ()
                {
                    return Yii::app()->user->model->id == $user_id;
                },
                'user'  => Yii::app()->controller->user
            ],
        ]
    ],
];
