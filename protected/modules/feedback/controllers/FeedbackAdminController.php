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
        $this->loadModel($id)->delete();

        if (!isset($_GET['ajax']))
        {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
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
