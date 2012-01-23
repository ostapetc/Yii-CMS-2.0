<?php

class YmarketBrand extends ActiveRecordModel
{
    const PAGE_SIZE = 10;


    public function name()
    {
        return 'Бренды Яндекс-маркета';
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'ymarket_brands';
	}


	public function rules()
	{
		return array(
			array('name', 'length', 'max' => 100),
            array('name', 'unique', 'className' => get_class($this), 'attributeName' => 'name'),
			array('id, name', 'safe', 'on' => 'search'),
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
		$criteria->compare('name', $this->name, true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}
}