<?
$this->widget('media.portlets.Uploader', array(
    'name'      => 'uploader',
    'model'     => new MediaAlbum,
    'uploadUrl' => $uploadUrl . '?nexturl=' . urlencode($nextUrl),
    'data_type' => 'video',
    'params'   => array(
        'forceIframeTransport' => true,
        'formData' => array(
            'token' => $token
        )
    )
));