<?
$this->widget('media.portlets.Uploader', array(
    'as_modal'   => false,
    'name'       => 'uploader',
    'model'      => $model,
    'tag'        => 'videos',
    'data_type'  => 'video',
    'upload_action' => $this->createUrl('/media/mediaFile/upload')
));