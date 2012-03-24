<?php

class FeedbackController extends BaseController
{
    public function actions()
   	{
   		return array(
   			// captcha action renders the CAPTCHA image displayed on the contact page
   			'captcha'=>array(
   				'class'     =>'CCaptchaAction',
   				'backColor' => 0xFFFFFF,
   			),
   		);
   	}


    public static function actionsTitles()
    {
        return array(
            'Create'  => 'Отправление сообщения'
        );
    }


    public function actionCreate()
    {
        $model = new Feedback();
        $form  = new BaseForm('feedback.FeedbackForm', $model);

        if(isset($_POST['ajax']) && $_POST['ajax'] === 'feedback-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['Feedback']))
        {
            $model->attributes = $_POST['Feedback'];
            if ($model->save())
            {
                $text = implode("<br/>", array(
                    "Обращается {$model->name}. <br>",
                    "Email: {$model->email}",
                    "Дата: " . date("d.m.Y H:i"),
                    "Тема: {$model->topic->name} <br/>",
                    $model->text,
                    CHtml::link("Посмотреть на сайте", $this->createAbsoluteUrl('/feedback/feedbackAdmin/view/', array('id' => $model->id)))
                ));

                $outbox_email = new OutboxEmail();
                $outbox_email->email   = $model->topic->email;
                $outbox_email->subject = 'Новое сообщение с сайта self-actualization.ru';
                $outbox_email->text    = $text;
                $outbox_email->save();

                file_get_contents("http://" . $_SERVER['HTTP_HOST'] . '/ru/mailer/OutboxEmail/SendEmails');

                Yii::app()->user->setFlash('success', 'Ваше сообщение успешно отправлено!');

                $this->redirect(base64_decode($_POST['Feedback']['from']));
            }
        }

        $this->render('create', array(
            'form' => $form
        ));
    }

}
