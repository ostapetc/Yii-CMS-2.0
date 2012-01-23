<?php

class MailerTemplateRecipient extends ActiveRecordModel
{
    const PAGE_SIZE = 10;


    public function name()
    {
        return 'Получатели шаблона рассылки';
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'mailer_templates_recipients';
	}


	public function rules()
	{
		return array(
			array('template_id, user_id', 'required'),
			array('template_id, user_id', 'length', 'max' => 11),

			array('id, template_id, user_id', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
			'user'     => array(self::BELONGS_TO, 'User', 'user_id'),
			'template' => array(self::BELONGS_TO, 'MailerTemplates', 'template_id'),
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id, true);
		$criteria->compare('template_id', $this->template_id, true);
		$criteria->compare('user_id', $this->user_id, true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}
}