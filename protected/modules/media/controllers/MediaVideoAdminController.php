<?
class MediaVideoAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "create"     => "Создать",
            "view"       => "Создать",
            "delete"     => "Удалить",
            "update"     => "Редактировать",
            "manage"     => "Управление альбомами",
            "youTubeUploadCallback" => "Управление альбомами",
            "getYouTubeUploadToken" => "Управление альбомами",
        );
    }


    public function actionManage()
    {
        $file = new MediaFile('search', 'youTube');
        $model = $file->getApi();
//        $model->unsetAttributes();

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

    public function actionYouTubeUploadCallback($status, $id)
    {
        echo $id;
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
