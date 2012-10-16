<?
$id     = 'non-moderated-grid';

$widget = $this->widget('AdminGridView', [
    'id'           => $id,
    'dataProvider' => $dp,
    'columns'      => [
        [
            'name' => 'title',
            'type' => 'raw'
        ],
        [
            'class'    => 'CButtonColumn',
            'header'   => 'Опубликовать',
            'template' => '{youtube}',
            'buttons'  => [
                'youtube' => [
                    'label'    => 'Опубликовать на YouTube',
                    'url'      => 'Yii::app()->createUrl("/media/mediaVideoAdmin/localToRemote", ["id"=>$data->id, "api" => "youTube"))',
                    'imageUrl' => $this->module->assetsUrl() . '/img/icons/youtube-32.png',
                    'click'    => 'js:function() {
                    	$.get($(this).attr("href"));
                    	$(this).parent().html("Видео отправляется, это займет некоторое время")
                     	return false;
                    }',
                ]
            ]
        ],
        [
            'class'    => 'CButtonColumn',
            'template' => '{update}{delete}',
            'deleteButtonUrl' => 'Yii::app()->createUrl("/media/mediaFileAdmin/delete",["id"=>$data->primaryKey))',
            'updateButtonUrl' => 'Yii::app()->createUrl("/media/mediaFileAdmin/update",["id"=>$data->primaryKey))',
        ]
    ],
]);
