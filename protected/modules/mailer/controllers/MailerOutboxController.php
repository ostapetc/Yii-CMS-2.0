<?

class MailerOutboxController extends Controller
{
    public static function actionsTitles()
    {
        return array(
            "SendEmails" => "Отправка писем",
            "ConfirmReceipt" => "Подтверждение получения письма"
        );
    }


    public function actionSendEmails()
    {
        Param::checkRequired(
            array(
                MailerModule::PARAM_REPLY_EMAIL,
                MailerModule::PARAM_FROM_EMAIL,
                MailerModule::PARAM_FROM_NAME,
                MailerModule::PARAM_PASSWORD,
                MailerModule::PARAM_LOGIN,
                MailerModule::PARAM_HOST,
                MailerModule::PARAM_PORT,
            ),
            'mailer'
        );

        MailerOutbox::sendEmails();
    }


    public function actionConfirmReceipt($letter_id, $user_id)
    {
        $user_id = str_replace('.jpg', null, $user_id);

        $recipient = MailerRecipient::model()->findByAttributes(array(
            'letter_id' => $letter_id,
            'user_id' => $user_id,
            'status' => MailerRecipient::STATUS_SENT
        ));

        if ($recipient)
        {
            $recipient->status = MailerRecipient::STATUS_ACCEPTED;
            $recipient->save();
        }
    }
}
