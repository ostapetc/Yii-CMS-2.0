<?php

class Product extends ActiveRecordModel
{
    const PAGE_SIZE = 10;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'products';
	}


    public function name()
    {
        return 'Модель Product';
    }


	public function rules()
	{
		return array(
			array('name, is_published', 'required'),
			array('is_published, order', 'numerical', 'integerOnly' => true),
			array('name', 'length', 'max' => 250),
            array('name', 'unique'),
			array('id, name, is_published, order, date_create', 'safe', 'on' => 'search'),
		);
	}


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['Sortable'] = array(
            'class' => 'application.extensions.sortable.SortableBehavior'
        );

        return $behaviors;
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
		$criteria->compare('is_published', $this->is_published);
		$criteria->compare('order', $this->order);
		$criteria->compare('date_create', $this->date_create, true);

        $sort = new CSort();
        $sort->defaultOrder = '`order` DESC';

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
            'sort'     => $sort
		));
	}
}