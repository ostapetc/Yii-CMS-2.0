<?php
class FileManagerAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "UpdateAttr"   => "Редактирование файла",
            "Upload"       => "Загрузка файлов",
            "SavePriority" => "Сортировка",
            "Delete"       => "Удаление файла",
            "ExistFiles"   => "Загрузка существующих файлов",
            "Manage"       => "Управление файлами"
        );
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


    private function sendFilesAsJson($files)
    {
        $res = array();
        foreach ((array)$files as $file)
        {
            $res[] = array(
                'title'          => $file['title'] ? $file['title'] : 'Кликните для редактирования',
                'descr'          => $file['descr'] ? $file['descr'] : 'Кликните для редактирования',
                'size'           => $file['size'],
                'url'            => $file['href'],
                'thumbnail_url'  => $file['icon'],
                'delete_url'     => $file['deleteUrl'],
                'delete_type'    => "GET",
                'edit_url' => $this->createUrl('/fileManager/fileManagerAdmin/updateAttr', array(
                    'id'  => $file['id'],
                )),
                'id'             => 'File_' . $file->id,
            );
        }

        echo CJSON::encode($res);
    }


    public function actionSavePriority()
    {
        $ids = array_reverse($_POST['File']);

        $files = new FileManager('sort');

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
        $model = new FileManager('search');
        $model->unsetAttributes();
        if (isset($_GET['FileManager']))
        {
            $model->attributes = $_GET['FileManager'];
        }

        $this->render('manage', array('model' => $model));
    }
}