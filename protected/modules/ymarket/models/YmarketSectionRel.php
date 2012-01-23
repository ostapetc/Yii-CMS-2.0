<?php

class YmarketSectionRel extends ActiveRecordModel
{
    const PAGE_SIZE = 10;

    const OBJECT_TYPE_BRAND   = 'brand';
    const OBJECT_TYPE_PRODUCT = 'product';


    public function name()
    {
        return 'Связи разделов Яндекс-маркета';
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'ymarket_sections_rels';
	}


	public function rules()
	{
		return array(
			array('object_id, section_id, object_type', 'required'),
			array('section_id, object_id', 'length', 'max' => 11),
			array('object_type', 'length', 'max' => 7),

			array('id, section_id, object_id, object_type', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
			'section' => array(self::BELONGS_TO, 'YmarketSections', 'section_id'),
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id, true);
		$criteria->compare('section_id', $this->section_id, true);
		$criteria->compare('object_id', $this->object_id, true);
		$criteria->compare('object_type', $this->object_type, true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}
}