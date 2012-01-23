<?php

class MailerRecipientAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'Manage' => 'Статистика получателей рассылки'
        );
    }


	public function actionManage()
	{
		$model=new MailerRecipient('search');
		$model->unsetAttributes();
		if(isset($_GET['MailerRecipient']))
        {
            $model->attributes = $_GET['MailerRecipient'];
        }
        
		$this->render('manage', array(
			'model' => $model,
		));
	}
}
