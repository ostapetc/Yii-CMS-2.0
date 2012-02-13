<?php

class FeedbackController extends BaseController
{   
    public static function actionsTitles() 
    {
        return array(
            "Create" => "Добавление сообщения"
        );
    }
    

    public function actionCreate()
    {   
        $model = new Feedback;
        $form  = new BaseForm('main.FeedbackForm', $model);

        $this->performAjaxValidation($model);

        if ($form->submitted('submit'))
        {
            $model = $form->model;
            if ($model->save())
            {
                Yii::app()->user->setFlash('feedback_done', Yii::t('MainModule.main', 'Сообщение успешно отправлено!'));
                $this->redirect($_SERVER['REQUEST_URI']);
            }
        }

        $this->render("create", array('form' => $form));
    }
}
