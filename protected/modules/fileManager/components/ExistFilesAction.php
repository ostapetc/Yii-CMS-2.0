<?php
class ExistFilesAction extends CAction
{
    public function run($model_id, $object_id, $tag)
    {
        if ($object_id == 0)
        {
            $object_id = 'tmp_' . Yii::app()->user->id;
        }

        $existFiles = FileManager::model()->parent($model_id, $object_id)->tag($tag)->findAll();
        $this->sendFilesAsJson($existFiles);
    }

    private function sendFilesAsJson($files)
    {
        $res = array();
        foreach ((array)$files as $file)
        {
            $res[] = array(
                'title'          => $file['title'] ? $file['title'] : 'Кликните для редактирования',
                'descr'          => $file['descr'] ? $file['descr'] : 'Кликните для редактирования',
                'url'            => $file['href'],
                'thumbnail_url'  => $file['icon'],
                'delete_url'     => $file['deleteUrl'],
                'delete_type'    => "post",
                'edit_url' => $this->controller->createUrl('/fileManager/fileManagerAdmin/updateAttr', array(
                    'id'  => $file['id'],
                )),
                'id'             => 'File_' . $file->id,
            );
        }

        echo CJSON::encode($res);
    }

}