<?php

class MailerLetter extends ActiveRecordModel
{
    const PAGE_SIZE = 10;

    const TEXT_PREVIEW_LENGTH = 150;
    

    public function name()
    {
        return 'Отчеты о рассылках';
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'mailer_letters';
	}


	public function rules()
	{
		return array(
			array('subject, text', 'required', 'on' => 'without_template'),
			array('template_id', 'length', 'max' => 11),
			array('subject', 'length', 'max' => 150),

			array('id, template_id, subject, text, date_create', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
			'template'   => array(self::BELONGS_TO, 'MailerTemplate', 'template_id'),
			'recipients' => array(self::HAS_MANY, 'MailerRecipient', 'letter_id'),
            'users'      => array(self::HAS_MANY, 'User', 'user_id', 'through' => 'recipients')
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id, true);
		$criteria->compare('template_id', $this->template_id, true);
		$criteria->compare('subject', $this->subject, true);
		$criteria->compare('text', $this->text, true);
		$criteria->compare('date_create', $this->date_create, true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}


    public function getTextContent($preview = false)
    {
        $text = $this->template ? $this->template->text : $this->text;

        if ($preview && mb_strlen($text, 'utf-8') > self::TEXT_PREVIEW_LENGTH)
        {
            $text = mb_substr($text, 0, self::TEXT_PREVIEW_LENGTH, 'utf-8') . '...';
        }

        return $text;
    }


	public function addRecipients($users_ids)
	{
		foreach ($users_ids as $user_id)
        {
            $recipient = MailerRecipient::model()->findByAttributes(array(
                'letter_id' => $this->id,
                'user_id'   => $user_id
            ));

            if ($recipient)
            {
                continue;
            }

        	$recipient = new MailerRecipient;
        	$recipient->letter_id = $this->id;
        	$recipient->user_id   = $user_id;
       		$recipient->save();
        }
	}


	public function deleteRecipients()
	{
    	foreach ($this->recipients as $recipient)
        {
        	$recipient->delete();
        }
	}


    public function updateRecipients($users_ids)
    {
        if ($users_ids)
        {
            $sql = "DELETE FROM " . MailerRecipient::model()->tableName() . "
                           WHERE letter_id = {$this->id} AND
                                 user_id NOT IN (" . implode(',', $users_ids) . ")";

            Yii::app()->db->createCommand($sql)->execute();

            $this->addRecipients($users_ids);
        }
        else
        {
            $this->deleteRecipients();
        }
    }


    public function sendLetters()
    {
        $first_sending = false;
		
        $settings = Setting::model()->findCodesValues();
      
        if (!isset($settings[MailerModule::SETTING_DISPATCH_TIME]))
        {
            $dispatch_time = new Setting;
            $dispatch_time->attributes = array(
	            'module_id' => Yii::app()->controller->module->id,
	            'name'      => 'Последнее время отправки',
	            'code'      => MailerModule::SETTING_DISPATCH_TIME,
	            'value'     => time(),
	            'hidden'    => 1            	
            );

            $dispatch_time->save();

            $settings[MailerModule::SETTING_DISPATCH_TIME] = $dispatch_time->value;

            $first_sending = true;
        }


        if (!$first_sending && ((time() - $settings[MailerModule::SETTING_DISPATCH_TIME]) < $settings[MailerModule::SETTING_TIMEOUT]))
        {	
            return;
        }

        $letters_sent_count = 0;

        $letters = MailerLetter::model()->findAll(array('order' => 'date_create'));
        foreach ($letters as $letter)
        {

            $recipients = $letter->recipients(array('condition' => "status = '" . MailerRecipient::STATUS_WAITING . "'"));
            if (!$recipients)
            {
                continue;
            }

            foreach ($recipients as $recipient)
            {
                $user = $recipient->user;

                $subject = $letter->template ? $letter->template->subject : $letter->subject;
                $subject = $this->compileText($subject, array('user' => $user));

                $body = $letter->template ? $letter->template->text : $letter->text;
                $body = $this->compileText($body, array('user' => $user));

                $body.= "<br><br>" . $settings[MailerModule::SETTING_SIGNATURE];
                $body.= "<img src='http://{$_SERVER['HTTP_HOST']}/mailer/Mailer/ConfirmReceipt/letter_id/{$letter->id}/user_id/{$user->id}.jpg' />";
          
                $sent = MailerModule::sendMail(
                    $user->email,
                    $subject,
                    $body,
                    $settings[MailerModule::SETTING_FROM_NAME],
                    $settings[MailerModule::SETTING_REPLY_ADDRESS],
                    $settings[MailerModule::SETTING_HOST],
                    $settings[MailerModule::SETTING_PORT],
                    $settings[MailerModule::SETTING_LOGIN],
                    $settings[MailerModule::SETTING_PASSWORD],
                    $settings[MailerModule::SETTING_ENCODING],
                    true
                );

                if ($sent)
                {
                    $recipient->status = MailerRecipient::STATUS_SENT;
                }
                else
                {
                    $recipient->status = MailerRecipient::STATUS_FAIL;
                }

                $recipient->save();

                $letters_sent_count++;

                echo $user->email . "<br/>";

                if ($letters_sent_count >= $settings[MailerModule::SETTING_LETTERS_PART_COUNT])
                {
                    $dispatch_time = Setting::model()->findByAttributes(array('code' => MailerModule::SETTING_DISPATCH_TIME));
                    $dispatch_time->value = new CDbExpression('NOW()');
                    $dispatch_time->save();

                    Yii::app()->end();
                }
            }
        }
    }


    public function compileText($text, $objects = array())
    {
        extract($objects);

        $fields = MailerField::model()->findAll();

        $codes  = array();
        $values = array();

        foreach ($fields as $field)
        {
            if (mb_substr($field->value, -1) != ';')
            {
                $field->value.= ';';
            }

            if (mb_substr($field->value, 0, 7) != 'return ')
            {
                $field->value = 'return ' . $field->value;
            }

            if (mb_strpos($text, $field->code) !== false)
            {
                $codes[]  = trim($field->code);
                $values[] = @eval($field->value);
            }
        }

        $text = urldecode($text);

        return str_replace($codes, $values, $text);
    }
}