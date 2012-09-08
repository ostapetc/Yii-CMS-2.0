<?php
/** 
 * 
 * !Attributes - атрибуты БД
 * @property                 $status
 * @property                 $id
 * @property                 $user_id
 * @property                 $template_id
 * @property                 $email
 * @property                 $subject
 * @property                 $body
 * @property                 $log
 * @property                 $date_create
 * @property                 $date_send
 * 
 * !Accessors - Геттеры и сеттеры класа и его поведений
 * @property                 $statusCaption
 * @property                 $errorsFlatArray
 * 
 * !Relations - связи
 * @property User            $user
 * @property MailerTemplate  $template
 * 
 * !Scopes - именованные группы условий, возвращают этот АР
 * @method   MailerOutbox    published()
 * @method   MailerOutbox    sitemap()
 * @method   MailerOutbox    ordered()
 * @method   MailerOutbox    last()
 * 
 */

class MailerOutbox extends ActiveRecord
{
    const STATUS_SENT    = 'sent';
    const STATUS_QUEUE   = 'queue';
    const STATUS_PROCESS = 'process';
    const STATUS_ERROR   = 'error';

    const PARAM_FROM_EMAIL  = 'from_email';
    const PARAM_FROM_NAME   = 'from_name';
    const PARAM_REPLY_EMAIL = 'reply_email';
    const PARAM_HOST        = 'host';
    const PARAM_PORT        = 'port';
    const PARAM_LOGIN       = 'login';
    const PARAM_PASSWORD    = 'password';

    const MAILS_PACKET_SIZE = 20;
    const PAGE_SIZE         = 10;

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
		return 'mailer_outbox';
	}


    public function name()
    {
        return 'Модель MailerOutbox';
    }


	public function rules()
	{
		return array(
			array('email, subject, body, template_id, user_id', 'required'),
			array('email, subject', 'length', 'max' => 250),
			array('date_send, log', 'safe'),
            array('email', 'email'),
            array('template_id', 'numerical', 'integerOnly' => true),
            array('user_id', 'numerical', 'integerOnly' => true),
            array('status', 'in', 'range' => self::$status_list),
			array('id, email, status, log, subject, body, date_create, date_send', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
            'user' => array(
                self::BELONGS_TO,
                'User',
                'user_id'
            ),
            'template' => array(
                self::BELONGS_TO,
                'MailerTemplate',
                'template_id'
            )
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('subject', $this->subject, true);
		$criteria->compare('template_id', $this->template_id);
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
        $outbox_emails = MailerOutbox::model()->findAllByAttributes(
            array('status' => MailerOutbox::STATUS_QUEUE),
            array(
                'order' => 'date_create',
                'limit' => self::MAILS_PACKET_SIZE
            )
        );

        foreach ($outbox_emails as $outbox_email)
        {
            //$outbox_email->status = MailerOutbox::STATUS_PROCESS;
            //$outbox_email->save();

            try
            {
                self::sendMail($outbox_email->email, $outbox_email->subject, $outbox_email->body);

                $outbox_email->date_send = new CDbExpression('NOW()');
                $outbox_email->status    = MailerOutbox::STATUS_SENT;
            }
            catch (Exception $e)
            {
                $outbox_email->status = MailerOutbox::STATUS_ERROR;
                $outbox_email->log    = $e->getMessage();
            }

            $outbox_email->save();
        }
    }


    public static function sendMail($email_to, $subject, $body)
    {
        Param::checkRequired(array(
            self::PARAM_FROM_EMAIL,
            self::PARAM_FROM_NAME,
            self::PARAM_REPLY_EMAIL,
            self::PARAM_HOST,
            self::PARAM_PORT,
            self::PARAM_LOGIN,
            self::PARAM_PASSWORD
        ));

        require_once LIBRARIES_PATH . 'PHPMailer/class.phpmailer.php';

        $settings = Param::model()->findCodesValues('mailer');

        $encoding    = "utf-8";
        $hidden_copy = true;

        $subject     = iconv($encoding, "{$encoding}//IGNORE", $subject);
        $from_name   = iconv($encoding, "{$encoding}//IGNORE", $settings[self::PARAM_FROM_NAME]);
        $from_email  = iconv($encoding, "{$encoding}//IGNORE", $settings[self::PARAM_FROM_EMAIL]);
        $reply_email = iconv($encoding, "{$encoding}//IGNORE", $settings[self::PARAM_REPLY_EMAIL]);

        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->CharSet       = $encoding;
        $mail->SMTPDebug     = 1;
        $mail->Host          = $settings[self::PARAM_HOST];
        $mail->SMTPAuth      = true;
        $mail->SMTPKeepAlive = true;
        $mail->Port          = $settings[self::PARAM_PORT];
        $mail->Username      = $settings[self::PARAM_LOGIN];
        $mail->Password      = $settings[self::PARAM_PASSWORD];

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


    public function beforeValidate()
    {
        if (parent::beforeValidate() && $this->isNewRecord)
        {
            $user     = User::model()->findByPk($this->user_id);
            $template = MailerTemplate::model()->findByPk($this->template_id);

            if (!$this->subject)
            {
                $this->subject = $template->constructSubject($user);
            }

            if (!$this->body)
            {
                $this->body = $template->constructBody($user);
            }

            if (!$this->email)
            {
                $this->email = $user->email;
            }
        }

        return true;
    }
}


