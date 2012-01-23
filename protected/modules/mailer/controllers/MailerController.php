<?php
 
class MailerController extends BaseController
{
    public static function actionsTitles()
    {
        return array(
            "SendMails"      => "Отправить письма",
            "ConfirmReceipt" => "Подтверждение получения письма"
        );
    }

    public function actionConfirmReceipt($letter_id, $user_id)
    {
        $user_id = str_replace('.jpg', null, $user_id);

        $recipient = MailerRecipient::model()->findByAttributes(array(
            'letter_id' => $letter_id,
            'user_id'   => $user_id,
            'status'    => MailerRecipient::STATUS_SENT
        ));

        if ($recipient)
        {
            $recipient->status = MailerRecipient::STATUS_ACCEPTED;
            $recipient->save();
            p($recipient->errorsHtml());
        }
    }


    public function actionSendMails()
    {
        MailerLetter::model()->sendLetters();
    }
}
