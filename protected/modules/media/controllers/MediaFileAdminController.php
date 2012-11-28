<?
class MediaFileAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return [
            "delete"       => "Удаление файла",
            "upload"       => "Скачать файл",
            "manage"       => "Скачать файл",
            "existFiles"   => "Скачать файл",
            "savePriority" => "Скачать файл",
            "updateAttr"   => "Скачать файл",
            "linkParser"   => "Скачать файл",
        ];
    }


    public function actions()
    {
        return [
            'updateAttr'   => [
                'class'      => 'media.components.UpdateAttrAction',
                'attributes' => [
                    'title',
                    'descr'
                ]
            ],
            'savePriority' => [
                'class' => 'media.components.SavePriorityAction',
            ]
        ];
    }


    public function actionLinkParser($object_id, $model_id, $tag)
    {
        if (isset($_POST['content']))
        {
            $model = MediaFile::parse($_POST['content']);
            if ($model)
            {
                $model->object_id = $object_id;
                $model->model_id  = $model_id;
                $model->tag       = $tag;
                $model->save();
                $this->sendFilesAsJson($model);
            }
            else
            {
                echo [
                    'status'  => 'error',
                    'message' => 'Текст не распознан'
                ];
            }
        }
        else
        {
            $this->forbidden();
        }
    }


    protected function sendFilesAsJson($files)
    {
        $res   = [];
        $files = is_array($files) ? $files : [$files];
        foreach ($files as $file)
        {
            $res[] = [
                'title'       => $file->title ? $file->title : 'Кликните для редактирования',
                'descr'       => $file->descr ? $file->descr : 'Кликните для редактирования',
                'url'         => $file->getHref(),
                'preview'     => $file->getPreviewArray(),
                'delete_url'  => $file->deleteUrl,
                'api'         => $file->api_name,
                'delete_type' => "post",
                'edit_url'    => $this->createUrl('/media/mediaFile/updateAttr', [
                    'id' => $file->id,
                ]),
                'id'          => 'File_' . $file->id,
            ];
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
            $this->sendFilesAsJson($model);
        }
        else
        {
            echo CJSON::encode([
                'textStatus' => $model->error
            ]);
        }
    }


    /* SECURE!

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
    */

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

        $this->render('manage', ['model' => $model]);
    }
}
