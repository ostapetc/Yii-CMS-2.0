<?php
 
class LogAdminController extends AdminController
{   
    public static function actionsTitles() 
    {
        return array(
            "Manage" => "Управление логами"
        );    
    }


    public function actionManage()
    {
        $model = new Log('search');
        $model->unsetAttributes();

        if (isset($_GET['Log']))
        {
            $model->attributes = $_GET['Log'];
        }

        $this->render('manage', array('model' => $model));
    }
}
