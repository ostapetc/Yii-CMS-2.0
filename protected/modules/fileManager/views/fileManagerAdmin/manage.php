<?php

function getObjectUpdateUrl($object_id, $model)
{
    if (!is_numeric($object_id) || !method_exists($model, 'updateUrl'))
    {
        return;
    }

    $object = ActiveRecordModel::model($model)->findByPk($object_id);
    if (!$object)
    {
        return;
    }

    return CHtml::link('перейти', $object->updateUrl());
}


function getFileLink($data)
{
    if (file_exists($data->path))
    {
         if ($data->is_image)
         {
             $basename = pathinfo($data->path, PATHINFO_BASENAME);

//             $path = str_replace($basename, '100x0_' . $basename, $data->path);

             $content = ImageHelper::thumb(
                FileManager::UPLOAD_PATH,
                $data->name,
                50,
                null,
                false
            );
         }
        else
        {
            $content = $data->title;
        }

        return Chtml::link($content, $data->url);
    }
    else
    {
        return $data->title;
    }
}


$this->widget('AdminGrid', array(
    'id' => 'fileManager-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array(
            'name'   => 'title',
            'value'  => 'getFileLink($data);',
            'type'   => 'raw',
            'filter' => false
        ),
        array(
            'name'   => 'tag',
            'value'  => '$data->tag',
            'filter' => false
        ),
        array(
            'name'   => 'model_id',
            'filter' => false
        ),
        array(
            'header' => 'Объект',
            'value'  => 'getObjectUpdateUrl($data->object_id, $data->model_id);',
            'type'   => 'raw',
            'filter' => false
        ),
        array(
            'header' => 'Адрес',
            'value'  => 'CHtml::textField("name", $data->url, array("style"=>"width:100%;"));',
            'type'   => 'raw',
            'filter' => false
        ),
		array(
			'class'    => 'CButtonColumn',
            'template' => '{delete}'
		),
    )
));