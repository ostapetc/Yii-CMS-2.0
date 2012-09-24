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
        );
    }


    public function actionManage()
    {
        $file = new MediaFile('search', 'youTube');
        $model = $file->getApi()->getApiModel();
        $model->unsetAttributes();

        if (isset($_GET[get_class($model)]))
        {
            $model->setAttributes($_GET[get_class($model)], false);
        }

        $this->render('manage', array(
            "model" => $model
        ));
    }




    public function actionCreate()
    {

        $myVideoEntry = new Zend_Gdata_YouTube_VideoEntry();

        $myVideoEntry->setVideoTitle('My Test Movie');
        $myVideoEntry->setVideoDescription('My Test Movie');
        // The category must be a valid YouTube category!
        $myVideoEntry->setVideoCategory('Autos');

        // Set keywords. Please note that this must be a comma-separated string
        // and that individual keywords cannot contain whitespace
        $myVideoEntry->SetVideoTags('cars, funny');

        $tokenHandlerUrl = 'http://gdata.youtube.com/action/GetUploadToken';
        $tokenArray      = $yt->getFormUploadToken($myVideoEntry, $tokenHandlerUrl);
        $tokenValue      = $tokenArray['token'];
        $postUrl         = $tokenArray['url'];
        $nextUrl = Yii::app()->request->getCurrentUri();

        // build the form
        $form = '<form action="'. $postUrl .'?nexturl='. $nextUrl .
            '" method="post" enctype="multipart/form-data">'.
            '<input name="file" type="file"/>'.
            '<input name="token" type="hidden" value="'. $tokenValue .'"/>'.
            '<input value="Upload Video File" type="submit" />'.
            '</form>';

        $this->render('create', array('postUrl' => $postUrl, 'nextUrl' => $nextUrl, 'tokenValue' => $tokenValue));
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
