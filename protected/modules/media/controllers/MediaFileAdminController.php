<?
class MediaFileAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "delete"       => "Удаление файла",
            "upload"       => "Скачать файл",
            "manage"       => "Скачать файл",
            "existFiles"   => "Скачать файл",
            "savePriority" => "Скачать файл",
            "updateAttr"   => "Скачать файл",
        );
    }


    public function actions()
    {
        return array(
            'updateAttr'   => array(
                'class'      => 'media.components.UpdateAttrAction',
                'attributes' => array(
                    'title',
                    'descr'
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
                'edit_url'       => $this->createUrl('/media/mediaFile/updateAttr', array(
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


        if ($model->save())
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


    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
    }


    public function actionUpdateAttr($id)
    {
        $model = $this->loadModel($id);

        $model->scenario = 'update';

        $this->performAjaxValidation($model);
        $attr = $_POST['attr'];
        if (isset($_POST[$attr]))
        {
            $model->$attr = trim(strip_tags($_POST[$attr]));

            if ($model->save(false))
            {
                echo $model->$attr;
            }
        }
    }


    public function actionManage()
    {
        $model = new MediaFile('search');
        $model->unsetAttributes();
        if (isset($_GET['MediaFile']))
        {
            $model->attributes = $_GET['MediaFile'];
        }

        $this->render('manage', array('model' => $model));
    }
}
