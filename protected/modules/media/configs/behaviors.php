<?php
return array(
    'local'   => array(
        'class'     => 'media.components.api.local.LocalApiBehavior',
        'api_model' => array(
            'class' => 'media.components.api.local.LocalApi'
        )
    ),
    'youTube' => array(
        'class'     => 'media.components.api.youTube.YouTubeApiBehavior',
        'icon'      => 'img/fileIcons/youtube-32.png',
        'api_model' => array(
            'class' => 'media.components.api.youTube.YouTubeApi'
        )
    ),
);