<?php

class MailerTemplate extends ActiveRecordModel
{
    const PAGE_SIZE = 10;


    public function name()
    {
        return 'Шаблоны рассылки';
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'mailer_templates';
	}


	public function rules()
	{
		return array(
			array('name, subject, text', 'required'),
			array('is_basic', 'numerical', 'integerOnly' => true),
			array('name, subject', 'length', 'max' => 150),
            array('name', 'unique', 'attributeName' => 'name', 'className' => 'MailerTemplate'),
			array('id, name, subject, text, is_basic, date_create', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
			'mailerLetters' => array(self::HAS_MANY, 'MailerLetters', 'template_id'),
			'recipients'    => array(self::HAS_MANY, 'MailerTemplateRecipient', 'template_id'),
            'users'         => array(self::HAS_MANY, 'User', 'user_id', 'through' => 'recipients')
		);
	}
	

	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('subject', $this->subject, true);
		$criteria->compare('text', $this->text, true);
		$criteria->compare('is_basic', $this->is_basic);
		$criteria->compare('date_create', $this->date_create, true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}
	
	
	public function addRecipients($users_ids) 
	{
		foreach ($users_ids as $user_id) 
        {
        	$template_recipient = new MailerTemplateRecipient();
        	$template_recipient->template_id = $this->id;
        	$template_recipient->user_id = $user_id;
       		$template_recipient->save();
        }	
	}
	
	
	public function deleteRecipients() 
	{
    	foreach ($this->recipients as $recipient) 
        {
        	$recipient->delete();
        }	
	}

    /*
     * TODO:Дублирование метода класса MailerLetter (пофиксить)
     */
    public function getTextContent($preview = false)
    {
        $text = $this->text;

        if ($preview && mb_strlen($text, 'utf-8') > MailerLetter::TEXT_PREVIEW_LENGTH)
        {
            $text = mb_substr($text, 0, MailerLetter::TEXT_PREVIEW_LENGTH, 'utf-8') . '...';
        }

        return $text;
    }
}