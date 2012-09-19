<?
$this->widget('media.portlets.Uploader', array(
    'name'      => 'uploader',
    'model'     => new MediaAlbum,
    'data_type' => 'video',
    'uploadUrl' => $postUrl . '?nexturl=' . $nextUrl,
    'options'   => array(
        'formData' => array(
            'token' => $tokenValue
        ),
    ),
));