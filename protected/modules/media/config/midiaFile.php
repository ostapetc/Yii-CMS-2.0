<?php
return [
    'local'    => [
        'class'             => 'media.components.api.local.LocalApiBehavior',
        'sizes'             => [
            'client_gallery' => [
                'width'  => 321,
                'height' => 256
            ]
        ],
        'api_map'           => [
            'video' => 'youTube',
            'img'   => 'local',
            'audio' => 'local',
            'doc'   => 'local',
        ],
        'new_record_status' => MediaFile::STATUS_ON_MODERATE,
        'api_model'         => [
            'class' => 'media.components.api.local.LocalApi'
        ]
    ],
    'remote'   => [
        'class'             => 'media.components.api.remote.RemoteApiBehavior',
        'api_model'         => [
            'class' => 'media.components.api.remote.RemoteApi'
        ],
        'new_record_status' => MediaFile::STATUS_ACTIVE,
    ],
    'youTube'  => [
        'class'     => 'media.components.api.youTube.YouTubeApiBehavior',
        'icon'      => '/img/icons/youtube-32.png',
        'sizes'     => [
            'client_gallery' => [
                'width'  => 321,
                'height' => 256
            ]
        ],
        'api_model' => [
            'class' => 'media.components.api.youTube.YouTubeApi'
        ]
    ],
    'vk'       => [
        'class'     => 'media.components.api.vk.VkApiBehavior',
        'icon'      => '/img/icons/vk-32.png',
        'sizes'     => [
            'client_gallery' => [
                'width'  => 321,
                'height' => 256
            ]
        ],
        'api_model' => [
            'class' => 'media.components.api.vk.VkApi'
        ]
    ],
    'vimeo'       => [
        'class'     => 'media.components.api.vimeo.VimeoApiBehavior',
        'icon'      => '/img/icons/vimeo-32.png',
        'sizes'     => [
            'client_gallery' => [
                'width'  => 321,
                'height' => 256
            ]
        ],
        'api_model' => [
            'class' => 'media.components.api.vimeo.VimeoApi'
        ]
    ],
];