<?php

class FeedbackAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "View"   => "Просмотр сообщений",
            "Delete" => "Удаление сообщений",
            "Manage" => "Управление сообщениями"
        );
    }


    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }


    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest)
        {
            $this->loadModel($id)->delete();

            if (!isset($_GET['ajax']))
            {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        }
        else
        {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }


    public function actionManage()
    {
        $model = new Feedback('search');
        $model->unsetAttributes();
        if (isset($_GET['Feedback']))
        {
            $model->attributes = $_GET['Feedback'];
        }

        $this->render('manage', array(
            'model' => $model,
        ));
    }
}
