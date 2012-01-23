<?php
class FileManagerController extends BaseController
{
    public static function actionsTitles()
    {
        return array(
            "DownloadFile" => "Скачать файл",
        );
    }

    public $x_send_file_enabled = true;

    public function actionDownloadFile($hash)
    {
        list($hash, $id) = explode('x', $hash);

        $model = FileManager::model()->findByPk(intval($id));
        if (!$model || $model->getHash() != $hash || !file_exists($model->path . '/' . $model->name))
        {
            $this->pageNotFound();
        }

        if ($this->x_send_file_enabled)
        {
            Yii::app()->request->xSendFile($model->server_path, array(
                'saveName'=>$model->name,
                'terminate'=>false,
            ));
        }
        else
        {
            $this->request->sendFile($model->name, $model->content);
        }
    }

}
