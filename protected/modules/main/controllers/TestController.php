<?php
 
class TestController extends CController
{
    public function actionSendMail()
    {
        MailerModule::sendMail("artem-moscow@yandex.ru", "Mailer Тест", "Все пиздато");
    }


	public function actionTestDbExport() 
	{
		
	}
}
