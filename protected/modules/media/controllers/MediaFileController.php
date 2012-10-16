<?
class MediaFileController extends ClientController {

    public static function actionsTitles()
    {
        return array(
            "downloadFile" => "Скачать файл",
            "upload"       => "Скачать файл",
            "existFiles"   => "Скачать файл",
            "savePriority" => "Скачать файл",
            "updateAttr"   => "Скачать файл",
            "linkParser"   => "Скачать файл",
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

    public function subMenuItems()
    {
        return array(
            array(
                'label' => t('Все'),
                'url'   => array('content/page/index')
            ),
            array(
                'label' => t('Лучшие'),
                'url'   => array('content/page/top')
            ),
            array(
                'label'   => Yii::app()->user->isGuest
                    ? : t('Ваши') . '(' . Page::model()->count('user_id = ' . Yii::app()->user->id) . ')',
                'url'     => array('/page/user/' . Yii::app()->user->id),
                'visible' => !Yii::app()->user->isGuest
            )
        );
    }


    public function sidebars()
    {
        return array(
            array(
                'actions'  => array('create', 'update'),
                'sidebars' => array(
                    array(
                        'widget',
                        'content.portlets.SectionCreateSidebar',
                    ),
                    array(
                        'widget',
                        'tags.portlets.TagCreateSidebar',
                    ),
                    array(
                        'partial',
                        'content.views.page._sidebarFormNotices'
                    )
                )
            ),
            array(
                'actions'  => array('index'),
                'sidebars' => array(
                    array(
                        'widget',
                        'content.portlets.PageSectionsSidebar'
                    ),
                    array(
                        'widget',
                        'comments.portlets.CommentsSidebar',
                    ),
                    array(
                        'widget',
                        'media.portlets.YouTubePlayList'
                    )
                    /*array(
                        'widget',
                        'content.portlets.NavigatorSidebar',
                    ),*/
                )
            ),
            array(
                'actions'  => array('view'),
                'sidebars' => array(
                    array(
                        'widget',
                        'content.portlets.PageInfoSidebar'
                    )
                )
            ),
            array(
                'actions'  => array('userPages'),
                'sidebars' => array(
                    array(
                        'widget',
                        'content.portlets.userPagesSidebar'
                    )
                )
            ),
        );
    }


    public function actionLinkParser($object_id, $model_id, $tag)
    {
        if (isset($_POST['content'])) {
            $model = MediaFile::parse($_POST['content']);
            if ($model) {
                $model->object_id = $object_id;
                $model->model_id = $model_id;
                $model->tag = $tag;
                $model->save();
                $this->sendFilesAsJson($model);
            } else {
                echo array(
                    'status'  => 'error',
                    'message' => 'Текст не распознан'
                );
            }
        } else {
            $this->forbidden();
        }
    }

    protected function sendFilesAsJson($files)
    {

        $res = array();
        $files = is_array($files) ? $files : array($files);
        foreach ($files as $file) {
            $res[] = array(
                'title'          => $file->title ? $file->title : 'Кликните для редактирования',
                'descr'          => $file->descr ? $file->descr : 'Кликните для редактирования',
                'url'            => $file->getHref(),
                'preview'        => $file->getPreviewArray(),
                'delete_url'     => $file->deleteUrl,
                'api'            => $file->api_name,
                'delete_type'    => "post",
                'edit_url'       => $this->createUrl('/media/mediaFile/updateAttr', array(
                    'id'  => $file->id,
                )),
                'id'             => 'File_' . $file->id,
            );
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


    public function actionSavePriority()
    {
        $ids = array_reverse($_POST['File']);

        $files = new MediaFile('sort');

        $case = SqlHelper::arrToCase('id', array_flip($ids), 't');
        $arr = implode(',', $ids);
        Yii::app()->db->getCommandBuilder()
            ->createSqlCommand("UPDATE {$files->tableName()} AS t SET t.order = {$case} WHERE t.id IN ({$arr})")
            ->execute();
    }


    public function actionUpload($model_id, $object_id, $tag)
    {
        if ($object_id == 0) {
            $object_id = 'tmp_' . Yii::app()->user->id;
        }

        $model = new MediaFile('insert');
        $model->object_id = $object_id;
        $model->model_id = $model_id;
        $model->tag = $tag;

        if ($model->save()) {
            $this->sendFilesAsJson(array($model));
        } else {
            echo CJSON::encode(array(
                'textStatus' => $model->error
            ));
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
            Yii::app()->request->xSendFile($model->server_path, array(
                'saveName' => $model->name,
                'terminate'=> false,
            ));
        } else {
            $this->request->sendFile($model->name, $model->content);
        }
    }

}
