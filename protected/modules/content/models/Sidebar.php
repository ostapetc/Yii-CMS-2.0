<?php

class Sidebar extends ActiveRecordModel
{
    const PAGE_SIZE = 10;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'sidebars';
	}


    public function name()
    {
        return 'Модель Sidebar';
    }


	public function rules()
	{
		return array(
			array('title, html, language', 'required'),
			array('order, is_published', 'numerical', 'integerOnly' => true),
			array('title', 'length', 'max' => 100),
			array('id, title, html, order', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
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


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id, true);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('html', $this->html, true);
		$criteria->compare('order', $this->order);

        $sort = new CSort();
        $sort->defaultOrder = '`order` DESC';

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
            'sort'     => $sort
		));
	}
}