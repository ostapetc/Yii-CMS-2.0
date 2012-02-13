<?php

class MailerField extends ActiveRecordModel
{
    const PAGE_SIZE = 10;


    public function name()
    {
        return 'Генерируемые поля';
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'mailer_fields';
	}


	public function rules()
	{
		return array(
			array('code, name, value', 'required'),
			array('code', 'length', 'max' => 50),
			array('name', 'length', 'max' => 200),
			array('value', 'length', 'max' => 250),
            array('code', 'unique', 'attributeName' => 'code', 'className' => 'MailerField'),
			array('name', 'unique', 'attributeName' => 'name', 'className' => 'MailerField'),
            array('code', 'filter', 'filter' => 'trim'),
            array('id, code, name, value', 'safe', 'on' => 'search'),
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
		$criteria->compare('code', $this->code, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('value', $this->value, true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}
}