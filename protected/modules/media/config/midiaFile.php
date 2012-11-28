<?php
return [
    'local'    => [
        'class'             => 'media.components.api.LocalApiBehavior',
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
    ],
    'remote'   => [
        'class'             => 'media.components.api.RemoteApiBehavior',
        'new_record_status' => MediaFile::STATUS_ACTIVE,
    ],
    'youTube'  => [
        'class'     => 'media.components.api.YouTubeApiBehavior',
        'icon'      => '/img/icons/youtube-32.png',
    ],
    'vk'       => [
        'class'     => 'media.components.api.VkApiBehavior',
        'icon'      => '/img/icons/vk-32.png',
    ],
    'vimeo'       => [
        'class'     => 'media.components.api.VimeoApiBehavior',
        'icon'      => '/img/icons/vimeo-32.png',
    ],
];