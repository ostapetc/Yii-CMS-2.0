<?
class MediaVideoAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "create"                => "Создать",
            "view"                  => "Создать",
            "delete"                => "Удалить",
            "update"                => "Редактировать",
            "manage"                => "Управление альбомами",
            "youTubeUploadCallback" => "Управление альбомами",
            "getYouTubeUploadToken" => "Управление альбомами",
        );
    }


    public function actionManage()
    {
        $file  = new MediaFile('search', 'youTube');
        $model = $file->getApi();

        if (isset($_GET[get_class($model)]))
        {
            $model->setAttributes($_GET[get_class($model)], false);
        }

        $this->render('manage', array(
            "model" => $model
        ));
    }


    public function actionGetYouTubeUploadToken($name)
    {
        $file = new MediaFile('create', 'youTube');
        $data = $file->getApi()->getUploadToken($name);
        $data['url'] .= '?nexturl=' . urlencode($this->createAbsoluteUrl('youTubeUploadCallback'));
        echo json_encode($data);
    }


    public function actionCreate()
    {
        $this->render('create', array('tokenUrl' => $this->createUrl('getYouTubeUploadToken')));
    }


    protected function sendFilesAsJson($files)
    {
        $res = array();
        $files = is_array($files) ? $files : array($files);
        foreach ($files as $file)
        {
            $res[] = array(
                'title'          => $file->title ? $file->title : 'Кликните для редактирования',
                'descr'          => $file->descr ? $file->descr : 'Кликните для редактирования',
                'preview'        => $file->getPreview(),
                'delete_url'     => $file->deleteUrl,
                'delete_type'    => "post",
                'edit_url'       => $this->createUrl('/media/mediaFile/updateAttr', array(
                    'id'  => $file->id,
                )),
                'id'             => 'File_' . $file->id,
            );
        }
//        echo json_encode($res);die;
        echo CJSON::encode($res);
    }


    public function actionYouTubeUploadCallback($status, $id)
    {
        switch ($status)
        {
            case 200:
                $file = new MediaFile('create', 'youTube');
                $file->remote_id = $id;
                $file->save();
                $this->sendFilesAsJson($file);
                break;
            default:
                throw new CException('what???');
                break;
        }
    }


    public function actionView($id)
    {
        $this->layout     = '//layouts/middle';
        $model            = $this->loadModel($id);
        $this->page_title = 'Альбом: ' . $model->title;
        $form             = new Form('Media.UploadFilesForm', $model);
        $this->render('view', array(
            'model' => $model,
            'form'  => $form
        ));
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

        if ($model->userCanEdit() && $model->save())
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


    public function actionUserAlbums($userId)
    {
        $this->layout     = '//layouts/middle';
        $user             = User::model()->findByPk($userId);
        $this->page_title = 'Альбомы пользователя ' . $user->getLink();
        $form             = new Form('media.AlbumForm', $user->getAttachedModel('MediaAlbum'));
        $this->render('userAlbums', array(
            'user' => $user,
            'form' => $form
        ));
    }
}
