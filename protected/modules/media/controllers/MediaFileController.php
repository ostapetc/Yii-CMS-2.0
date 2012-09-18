<?
class MediaFileController extends ClientController
{
    public static function actionsTitles()
    {
        return array(
            "downloadFile" => "Скачать файл",
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
                'class' => 'media.components.UpdateAttrAction',
                'attributes' => array(
                    'title', 'descr'
                )
            ),
            'savePriority' => array(
                'class' => 'media.components.SavePriorityAction',
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
                'edit_url' => $this->createUrl('/media/mediaFile/updateAttr', array(
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

        $existFiles = MediaFile::model()->parent($model_id, $object_id)->tag($tag)->findAll();
        $this->sendFilesAsJson($existFiles);
    }

    public function actionSavePriority()
    {
        $ids = array_reverse($_POST['File']);

        $files = new MediaFile('sort');

        $case = SqlHelper::arrToCase('id', array_flip($ids), 't');
        $arr  = implode(',', $ids);
        Yii::app()->db->getCommandBuilder()
            ->createSqlCommand("UPDATE {$files->tableName()} AS t SET t.order = {$case} WHERE t.id IN ({$arr})")
            ->execute();
    }


    public function actionUpload($model_id, $object_id, $tag)
    {
        if ($object_id == 0)
        {
            $object_id = 'tmp_' . Yii::app()->user->id;
        }

        $model            = new MediaFile('insert');
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

    public $x_send_file_enabled = true;


    public function actionDownloadFile($hash)
    {
        list($hash, $id) = explode('x', $hash);

        $model =  MediaFile::model()->findByPk(intval($id));
        if (!$model || $model->getHash() != $hash || !file_exists($model->path . '/' . $model->name))
        {
            $this->pageNotFound();
        }

        if ($this->x_send_file_enabled)
        {
            Yii::app()->request->xSendFile($model->server_path, array(
                'saveName' => $model->name,
                'terminate'=> false,
            ));
        }
        else
        {
            $this->request->sendFile($model->name, $model->content);
        }
    }

}
