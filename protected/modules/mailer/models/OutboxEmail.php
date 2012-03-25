<?php

class OutboxEmail extends ActiveRecord
{
    const STATUS_SENT    = 'sent';
    const STATUS_QUEUE   = 'queue';
    const STATUS_PROCESS = 'process';
    const STATUS_ERROR   = 'error';

    const PAGE_SIZE = 10;


    public static $status_list = array(
        self::STATUS_SENT    => 'Отправлено',
        self::STATUS_QUEUE   => 'В очереди',
        self::STATUS_PROCESS => 'Отправляется',
        self::STATUS_ERROR   => 'Ошибка отправки'
    );


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'outbox_emails';
	}


    public function name()
    {
        return 'Модель OutboxEmail';
    }


	public function rules()
	{
		return array(
			array('email, subject, text', 'required'),
			array('email, user_name, subject', 'length', 'max' => 250),
			array('solution', 'length', 'max' => 100),
			array('date_send, log', 'safe'),
            array('status', 'in', 'range' => self::$status_list),
			array('id, email, user_name, solution, status, log, subject, text, date_create, date_send', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('user_name', $this->user_name, true);
		$criteria->compare('solution', $this->solution, true);
		$criteria->compare('subject', $this->subject, true);
		$criteria->compare('text', $this->text, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('log', $this->log, true);
		$criteria->compare('date_create', $this->date_create, true);
		$criteria->compare('date_send', $this->date_send, true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}


    public function getStatusCaption()
    {
        if (isset(self::$status_list[$this->status]))
        {
            return self::$status_list[$this->status];
        }
    }


    public static function sendEmails()
    {
        $outbox_emails = OutboxEmail::model()->findAllByAttributes(
            array('status' => OutboxEmail::STATUS_QUEUE),
            array('order'  => 'date_create')
        );

        foreach ($outbox_emails as $outbox_email)
        {
            $outbox_email->status = OutboxEmail::STATUS_PROCESS;
            $outbox_email->save();

            try
            {
                self::sendMail($outbox_email->email, $outbox_email->subject, $outbox_email->text);

                $outbox_email->date_send = new CDbExpression('NOW()');
                $outbox_email->status    = OutboxEmail::STATUS_SENT;
            }
            catch (Exception $e)
            {
                $outbox_email->status = OutboxEmail::STATUS_ERROR;
                $outbox_email->log    = $e->getMessage();
            }

            $outbox_email->save();
        }
    }


    private static function sendMail($email_to, $subject, $body)
    {
        require_once LIBRARY_PATH . 'PHPMailer_v5.1/class.phpmailer.php';

        $settings = Param::model()->findCodesValues('mailer');

        $encoding    = "utf-8";
        $hidden_copy = true;

        $subject     = iconv($encoding, "{$encoding}//IGNORE", $subject);
        $from_name   = iconv($encoding, "{$encoding}//IGNORE", $settings["from_name"]);
        $from_email  = iconv($encoding, "{$encoding}//IGNORE", $settings["from_email"]);
        $reply_email = iconv($encoding, "{$encoding}//IGNORE", $settings["reply_email"]);

        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->CharSet       = $encoding;
        $mail->SMTPDebug     = 1;
        $mail->Host          = $settings["host"];
        $mail->SMTPAuth      = true;
        $mail->SMTPKeepAlive = true;
        $mail->Port          = $settings["port"];
        $mail->Username      = $settings["login"];
        $mail->Password      = $settings["password"];

        $mail->AddReplyTo($reply_email, $from_name);

        $add_address_method = $hidden_copy ? 'AddBCC' : 'AddAddress';

        if (is_array($email_to))
        {
            foreach ($email_to as $ind => $email)
            {
                $mail->$add_address_method($email, $email);
            }
        }
        else
        {
            $mail->$add_address_method($email_to, $email_to);
        }

        $mail->SetFrom($from_email, $from_name);
        $mail->Subject = $subject;
        $mail->MsgHTML(iconv($encoding,"{$encoding}//IGNORE", $body));
        $mail->Send();

        $mail->ClearAttachments();
        $mail->ClearBCCs();
        $mail->ClearAddresses();
    }
}


