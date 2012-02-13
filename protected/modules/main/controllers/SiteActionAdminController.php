<?php

class SiteActionAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "Manage" => "Просмотр действий сайта"
        );
    }


    public function actionManage()
    {
        $model = new SiteAction('search');
        $model->unsetAttributes();
        if (isset($_GET['SiteAction']))
        {
            p($_GET['SiteAction']);
            $model->attributes = $_GET['SiteAction'];
        }

        $this->render('manage', array(
            'model' => $model,
        ));
    }
}
