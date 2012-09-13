<?
class MediaAlbumController extends ClientController
{
    public static function actionsTitles()
    {
        return array(
            "create"     => "Создать",
            "view"       => "Создать",
            "delete"     => "Удалить",
            "update"     => "Редактировать",
            "manage"     => "Управление альбомами",
            "userAlbums" => "Альбомы пользователя",
        );
    }


    public function actionCreate()
    {
        $model = new MediaAlbum;
        $form  = new Form('media.AlbumForm', $model);

        if ($form->submitted('submit') && !$model->validate())
        {
            $this->performAjaxValidation($model);
        }

        if ($model->userCanEdit())
        {
            $model->save(false);
        }
        else
        {
            $this->forbidden();
        }
    }


    public function actionView($id)
    {
        $this->layout = '//layouts/middle';
        $model = $this->loadModel($id);
        $this->page_title = 'Альбом: '.$model->title;
        $form  = new Form('Media.UploadFilesForm', $model);
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

        if ($model->saveFile() && $model->userCanEdit() && $model->save())
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
        $this->layout = '//layouts/middle';
        $user         = User::model()->findByPk($userId);
        $this->page_title = 'Альбомы пользователя ' . $user->getLink();
        $form         = new Form('media.AlbumForm', $user->getNewAttachedModel('MediaAlbum'));
        $this->render('userAlbums', array(
            'user' => $user,
            'form' => $form
        ));
    }
}
