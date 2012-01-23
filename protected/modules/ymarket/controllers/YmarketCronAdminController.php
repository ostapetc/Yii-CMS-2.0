<?php
 
class YmarketCronAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "Manage" => "Фоновые задания",
            "Update" => "Редактирование фонового задания"
        );
    }


    public function actionManage()
    {
        $this->render('manage', array('model' => new YmarketCron('search')));
    }


    public function actionUpdate($id)
    {
        $model = YmarketCron::model()->findByPk($id);
        if (!$model)
        {
            $this->pageNotFound();
        }

        $form = new BaseForm('ymarket.CronForm', $model);

        if (isset($_POST['YmarketCron']))
        {
            $model->attributes = $_POST['YmarketCron'];
            if ($model->save())
            {
                $this->redirect($this->createUrl("manage"));
            }
        }

        $this->render('update', array(
            'form' => $form
        ));
    }
}
