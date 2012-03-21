<?php

class OrderController extends BaseController
{
    public static function actionsTitles()
    {
        return array(
            'Create' => 'Создание заказа',
        );
    }


	public function actionCreate()
	{
		$model = new Order;
		
		$form = new BaseForm('services.OrderForm', $model);
		
		$this->performAjaxValidation($model);

		if(isset($_POST['Order']))
		{
			$model->attributes = $_POST['Order'];
			if($model->save())
            {
//                file_get_contents("http://" . $_SERVER['HTTP_HOST'] . '/ru/mailer/OutboxEmail/SendEmails');

                Yii::app()->user->setFlash('success', 'Ваш заказ успешно оформлен!');
                $this->redirect(base64_decode($_POST['Order']['from']));
            }
		}

		$this->render('create', array(
			'form' => $form,
		));
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'order-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
