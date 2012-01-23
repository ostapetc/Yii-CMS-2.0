<?php
class CabinetController extends BaseController
{
    public static function actionsTitles()
    {
        return array(
            "Index" => "Личный кабинет",
        );
    }

    public function actionIndex()
    {
        if (Yii::app()->user->isGuest)
        {
            $this->redirect(Yii::app()->homeUrl);
        }

        $model           = User::model()->findByPk(Yii::app()->user->id);
        $model->scenario = User::SCENARIO_CABINET;
        $form            = new BaseForm('users.CabinetForm', $model);

        $this->performAjaxValidation($model);
        if ($form->submitted('submit'))
        {
            $model = $form->model;
            if ($model->save())
            {
                Yii::app()->user->setFlash('cabinet_form_success', "Ваша информация обновлена успешно");
            }
        }

        $this->render('index', array(
            'form'      => $form
        ));
    }

}


