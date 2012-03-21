<?php

class Order extends ActiveRecordModel
{
    const PAGE_SIZE = 10;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'orders';
	}


    public function name()
    {
        return 'Модель Order';
    }


	public function rules()
	{
		return array(
			array('product_id, name, email, captcha', 'required'),
            array('captcha', 'CaptchaValidator', 'captchaAction' => '/main/help/captcha'),
			array('product_id', 'length', 'max' => 11),
			array('name, email, action_code', 'length', 'max' => 250),
            array('email', 'email'),
            array('product_id, name, email, comment, action_code, comment', 'filter', 'filter' => 'strip_tags'),
			array('id, product_id, name, email, action_code, comment, date_create', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id, true);
		$criteria->compare('product_id', $this->product_id, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('action_code', $this->action_code, true);
		$criteria->compare('comment', $this->comment, true);
		$criteria->compare('date_create', $this->date_create, true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}
}