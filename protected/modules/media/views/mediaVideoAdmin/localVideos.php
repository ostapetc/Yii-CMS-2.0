<?
$id     = 'non-moderated-grid';

$widget = $this->widget('AdminGridView', array(
    'id'           => $id,
    'dataProvider' => $dp,
    'columns'      => array(
        array(
            'name' => 'title',
            'type' => 'raw'
        ),
        array(
            'class'    => 'CButtonColumn',
            'header'   => 'Опубликовать',
            'template' => '{youtube}',
            'buttons'  => array(
                'youtube' => array(
                    'label'    => 'Опубликовать на YouTube',
                    'url'      => 'Yii::app()->createUrl("/media/mediaVideoAdmin/localToRemote", array("id"=>$data->id, "api" => "youTube"))',
                    'imageUrl' => $this->module->assetsUrl() . '/img/icons/youtube-32.png',
                    'click'    => 'js:function() {
                    	$.get($(this).attr("href"));
                    	$(this).parent().html("Видео отправляется, это займет некоторое время")
                     	return false;
                    }',
                )
            )
        ),
        array(
            'class'    => 'CButtonColumn',
            'template' => '{update}{delete}',
            'deleteButtonUrl' => 'Yii::app()->createUrl("/media/mediaFileAdmin/delete",array("id"=>$data->primaryKey))',
            'updateButtonUrl' => 'Yii::app()->createUrl("/media/mediaFileAdmin/update",array("id"=>$data->primaryKey))',
        )
    ),
));
