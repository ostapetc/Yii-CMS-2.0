<?
//yiicms2@yahoo.com
//yiicms2pass
class FileManagerAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "delete"   => "Удаление файла",
            "upload" => "Скачать файл",
            "existFiles" => "Скачать файл",
            "savePriority" => "Скачать файл",
            "updateAttr" => "Скачать файл",
        );
    }

    public function actions()
    {
        return array(
            'updateAttr' => array(
                'class' => 'fileManager.components.UpdateAttrAction',
                'attributes' => array(
                    'title', 'descr'
                )
            ),
            'savePriority' => array(
                'class' => 'fileManager.components.SavePriorityAction',
            )
        );
    }

    protected function sendFilesAsJson($files)
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
                'edit_url' => $this->createUrl('/fileManager/fileManager/updateAttr', array(
                    'id'  => $file['id'],
                )),
                'id'             => 'File_' . $file->id,
            );
        }

        echo CJSON::encode($res);
    }

    public function actionExistFiles($model_id, $object_id, $tag)
    {
        if ($object_id == 0)
        {
            $object_id = 'tmp_' . Yii::app()->user->id;
        }

        $existFiles = FileManager::model()->parent($model_id, $object_id)->tag($tag)->findAll();
        $this->sendFilesAsJson($existFiles);
    }

    public function actionUpload($model_id, $object_id, $tag)
    {
        if ($object_id == 0)
        {
            $object_id = 'tmp_' . Yii::app()->user->id;
        }

        $model            = new FileManager('insert');
        $model->object_id = $object_id;
        $model->model_id  = $model_id;
        $model->tag       = $tag;

        if ($model->saveFile() && $model->save())
        {
            $this->sendFilesAsJson(array($model));
        }
        else
        {
            echo CJSON::encode(array(
                'textStatus' => $model->error
            ));
        }

    }


    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
    }


    public function actionUpdateAttr($id)
    {
    }


}
