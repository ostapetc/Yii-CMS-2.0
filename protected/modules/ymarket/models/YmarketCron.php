<?php

class YmarketCron extends ActiveRecordModel
{
    const PAGE_SIZE = 10;


    public function name()
    {
        return 'Фоновые задачи Яндекс-маркета';
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'ymarket_crons';
	}


	public function rules()
	{
		return array(
			array('name, method, is_active, priority, interval, date_of', 'required'),
			array('is_active, priority, interval', 'numerical', 'integerOnly' => true),
			array('name', 'length', 'max' => 250),
			array('method', 'length', 'max' => 100),
            array('name', 'unique', 'className' => get_class($this), 'attributeName' => 'name'),
			array('id, name, method, is_active, priority, interval, date_of', 'safe', 'on' => 'search'),
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
		$criteria->compare('method', $this->method, true);
		$criteria->compare('is_active', $this->is_active);
		$criteria->compare('priority', $this->priority);
		$criteria->compare('interval', $this->interval);
		$criteria->compare('date_of', $this->date_of, true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}


    public function ParseAndUpdateSection()
    {
        $criteria = new CDbCriteria;
        $criteria->order = 'date_update';

        $section = YmarketSection::model()->find($criteria);
        echo $section->id;
        $section->parseAndUpdateAttributes();
    }


    public function ParseAndUpdateSectionBrands()
    {
        $criteria = new CDbCriteria;
        $criteria->order = 'date_brand_update';

        $section = YmarketSection::model()->find($criteria);
        $section->parseAndUpdateBrands();
    }


    public function ParsePages()
    {
        YmarketPage::model()->parse();
    }


    public function ParseProducts()
    {
        YmarketProduct::model()->parse();
    }
}