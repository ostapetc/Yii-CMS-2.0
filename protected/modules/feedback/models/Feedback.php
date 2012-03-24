<?php

class Feedback extends ActiveRecordModel
{
    const PAGE_SIZE = 10;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'feedback';
	}


    public function name()
    {
        return 'Модель Feedback';
    }


	public function rules()
	{
		return array(
			array('topic_id, name, email, text, captcha', 'required'),
            array('captcha', 'CaptchaValidator', 'captchaAction' => '/main/help/captcha'),
			array('topic_id', 'length', 'max' => 11),
			array('name, email', 'length', 'max' => 200),
            array('email', 'email'),
            array('topic_id, name, email, text', 'filter', 'filter' => 'strip_tags'),
			array('id, topic_id, name, email, text', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
			'topic' => array(self::BELONGS_TO, 'FeedbackTopic', 'topic_id'),
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id, true);
		$criteria->compare('topic_id', $this->topic_id, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('text', $this->text, true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}
}