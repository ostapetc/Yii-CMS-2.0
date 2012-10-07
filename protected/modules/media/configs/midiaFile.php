<?php
return array(
    'local'   => array(
        'class'     => 'media.components.api.local.LocalApiBehavior',
        'sizes' => array(
            'client_gallery' => array(
                'width' => 321,
                'height' => 256
            )
        ),
        'api_map' => array(
            'video' => 'youTube',
        ),
        'new_record_status' => MediaFile::STATUS_ON_MODERATE,
        'api_model' => array(
            'class' => 'media.components.api.local.LocalApi'
        )
    ),
    'youTube' => array(
        'class'     => 'media.components.api.youTube.YouTubeApiBehavior',
        'icon'      => '/img/icons/youtube-32.png',
        'sizes' => array(
            'client_gallery' => array(
                'width' => 321,
                'height' => 256
            )
        ),
        'api_model' => array(
            'class' => 'media.components.api.youTube.YouTubeApi'
        )
    ),
);