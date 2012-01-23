<?php

class MailerRecipient extends ActiveRecordModel
{
    const PAGE_SIZE = 10;

    const STATUS_ACCEPTED = 'accepted';
    const STATUS_WAITING  = 'waiting';
    const STATUS_FAIL     = 'fail';
    const STATUS_SENT     = 'sent';


    public static  $statuses = array(
        self::STATUS_ACCEPTED => 'Принято',
        self::STATUS_WAITING  => 'Ожидает',
        self::STATUS_FAIL     => 'Непринято',
        self::STATUS_SENT     => 'Отправлено'
    );


    public function name()
    {
        return 'Получатели рассылки';
    }


    public function scopes()
    {
        $scopes = array();
        
        foreach (self::$statuses as $status => $title)
        {
            $scopes[$status] = array('condition' => "status = '" . $status . "'");
        }

        return $scopes;
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'mailer_recipients';
	}


	public function rules()
	{
		return array(
			array('letter_id, user_id', 'required'),
			array('letter_id, user_id', 'length', 'max' => 11),
			array('status', 'length', 'max' => 8),

			array('id, letter_id, user_id, status, date_create', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'mailerRecipients' => array(self::HAS_MANY, 'MailerRecipient', 'user_id'),
			'letter' => array(self::BELONGS_TO, 'MailerLetters', 'letter_id'),
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id, true);
		$criteria->compare('letter_id', $this->letter_id, true);
		$criteria->compare('user_id', $this->user_id, true);
		$criteria->compare('status', $this->status, true);
		$criteria->compare('date_create', $this->date_create, true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}
}