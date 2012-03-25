<?php

class OutboxEmailController extends BaseController
{
    public static function actionsTitles()
    {
        return array(
            "SendEmails" => "Отправка писем"
        );
    }


    public function actionSendEmails()
    {
        OutboxEmail::sendEmails();
    }
}
