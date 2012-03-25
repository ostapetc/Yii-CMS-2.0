<?php

class FeedbackTopic extends ActiveRecordModel
{
    const PAGE_SIZE = 10;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'feedback_topics';
	}


    public function name()
    {
        return 'Модель FeedbackTopic';
    }


	public function rules()
	{
		return array(
			array('name, email', 'required'),
			array('name, email', 'length', 'max' => 250),
            array('name', 'unique'),
            array('email', 'email'),
			array('id, name, email', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
			'feedbacks' => array(self::HAS_MANY, 'Feedback', 'topic_id'),
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('email', $this->email, true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}
}