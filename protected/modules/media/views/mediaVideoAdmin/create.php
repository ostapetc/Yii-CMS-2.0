<?
$this->widget('media.portlets.Uploader', array(
    'name'      => 'uploader',
    'model'     => new MediaAlbum,
    'preview_width' => '220px',
    'upload_url' => $tokenUrl,
    'data_type' => 'video',
    'params'   => array(
        'forceIframeTransport' => true,
        'submit' => "js:function (e, data) {
            var that = $(this),
                file = data.files[0];
            $.get(that.data('fileupload').options.url, { name:file.name }, function (result) {
                data.url = result.url;
                data.formData = {token: result.token};
                that.fileupload('send', data);
            }, 'json');
            return false;
        }"
    )
));