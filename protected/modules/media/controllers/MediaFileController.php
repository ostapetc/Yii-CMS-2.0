<?
class MediaFileController extends ClientController {

    public static function actionsTitles()
    {
        return [
            "downloadFile" => "Скачать файл",
            "upload"       => "Скачать файл",
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
        if (!isset($_POST['content'])) {
            $this->forbidden();
        }

        $model = MediaFile::parse($_POST['content']);
        if ($model)
        {
            $model->object_id = $object_id;
            $model->model_id = $model_id;
            $model->tag = $tag;
            $existsFile = MediaFile::model()->findByAttributes(array(
                'remote_id' => $model->remote_id,
                'api_name' => $model->api_name
            ));
            if ($existsFile)
            {
                echo json_encode([
                    'errors' => [
                        [
                            'error' => 'Видео уже было добавлено на сайт'
                        ]
                    ]
                ]);
                return;
            }

            $model->save();
            $this->sendFilesAsJson($model);
        }
        else
        {
            echo json_encode([
                'errors' => [
                    [
                        'error' => 'Текст не распознан'
                    ]
                ]
            ]);
        }
    }

    protected function sendFilesAsJson($files)
    {
        $res = [];
        $files = is_array($files ) ? $files : [$files];
        foreach ($files as $file) {

            $res[] = [
                'title'          => $file->title ? $file->title : 'Кликните для редактирования',
                'descr'          => $file->descr ? $file->descr : 'Кликните для редактирования',
                'url'            => $file->getHref(),
                'preview'        => $file->getPreviewArray(),
                'delete_url'     => $file->deleteUrl,
                'api'            => $file->api_name,
                'delete_type'    => "post",
                'edit_url'       => $this->createUrl('/media/mediaFile/updateAttr', [
                    'id'  => $file->id,
                ]),
                'id'             => 'File_' . $file->id,
            ];
        }

        echo CJSON::encode($res);
    }


    public function actionExistFiles($model_id, $object_id, $tag)
    {
        if ($object_id == 0) {
            $object_id = 'tmp_' . Yii::app()->user->id;
        }


        $existFiles = MediaFile::model()->parent($model_id, $object_id)->tag($tag)->findAll();
        $this->sendFilesAsJson($existFiles);
    }

    /*Secure!

    public function actionSavePriority()
    {
        $ids = array_reverse($_POST['File']);

        $files = new MediaFile('sort');

        $case = SqlHelper::arrToCase('id', array_flip($ids), 't');
        $arr = implode(',', $ids);
        Yii::app()->db->getCommandBuilder()
            ->createSqlCommand("UPDATE {$files->tableName()} AS t SET t.order = {$case} WHERE t.id IN ({$arr})")
            ->execute();
    }*/


    public function actionUpload($model_id, $object_id, $tag)
    {
        if ($object_id == 0) {
            $object_id = 'tmp_' . Yii::app()->user->id;
        }

        $model = new MediaFile('insert', 'local');
        $model->object_id = $object_id;
        $model->model_id = $model_id;
        $model->tag = $tag;

        if ($model->save()) {
            $this->sendFilesAsJson($model);
        } else {
            echo CJSON::encode([
                'textStatus' => $model->error
            ]);
        }

    }


    public $x_send_file_enabled = true;


    public function actionDownloadFile($hash)
    {
        list($hash, $id) = explode('x', $hash);

        $model = MediaFile::model()->findByPk(intval($id));
        if (!$model || $model->getHash() != $hash || !$model->getIsFileExist()) {
            $this->pageNotFound();
        }

        if ($this->x_send_file_enabled) {
            Yii::app()->request->xSendFile($model->server_path, [
                'saveName' => $model->name,
                'terminate'=> false,
            ]);
        } else {
            $this->request->sendFile($model->name, $model->content);
        }
    }

}
