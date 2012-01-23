<?php

class FaqController extends BaseController
{
    public static function actionsTitles() 
    {
        return array(
            "Index"  => "Просмотр списка вопросов",
            "Create" => "Добавление вопроса"
        );
    }
    

    public function actionIndex($section_id)
    {   
        $section = FaqSection::model()->findByPk($section_id);
        if (!$section)
        {
            $this->pageNotFound();
        }

        $faqs = Faq::model()->last()->findAllByAttributes(array(
            'is_published' => 1,
            'section_id'   => $section_id
        ));

        $this->render('index', array(
            'section' => $section,
            'faqs'    => $faqs
        ));
    }


    public function actionCreate()
    {
        $model = new Faq('ClientSide');
        $form  = new BaseForm("faq.FaqForm", $model);

        if (isset($_POST['Faq']))
        {
            $model->attributes = $_POST['Faq'];
            if ($model->save())
            {
                $form->clear();
                Yii::app()->user->setFlash('faq_form_success', 'Ваш вопрос получен');

                $email = Setting::model()->getValue('feedback_email');
                $body = $this->renderPartial('email', array('model'=>$model), true);
                $title = 'Новый вопрос в обратной связи';
                Yii::app()->getModule('mailer')->sendMail($email, $title, $body);

            }
        }

        $this->render('create', array(
            'form' => $form
        ));
    }
}
