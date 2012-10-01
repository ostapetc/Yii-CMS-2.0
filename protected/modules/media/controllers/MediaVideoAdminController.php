<?
class MediaVideoAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "create"        => "Редактировать",
            "manage"        => "Управление альбомами",
            "localVideos"   => "Управление альбомами",
            "localToRemote" => "Управление альбомами",
        );
    }


    public function actionLocalVideos($status)
    {
        $file = new MediaFile('search', 'local');
        $dp   = $file->getDataProvider();

        $this->render('localVideos', array(
            'dp' => $dp
        ));
    }

    public function actionLocalToRemote($id, $api)
    {
        $file      = MediaFile::model()->findByPk($id);
        $local_api = $file->getApi();
        if ($local_api instanceof LocalApi)
        {
            $file->setApi($api);
            $file->convertFromLocal($local_api);
            if ($file->save())
            {
                echo json_encode(array('status' => 'ok'));
                return true;
            }
        }
        echo json_encode(array('status' => 'error'));
    }


    public function actionCreate()
    {
        $this->render('create');
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

}
