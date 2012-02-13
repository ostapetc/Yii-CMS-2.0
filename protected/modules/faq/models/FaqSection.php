<?php

class FaqSection extends ActiveRecordModel
{
    const PAGE_SIZE = 10;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    public function name()
    {
        return 'Разделы вопросов и ответов';
    }


	public function tableName()
	{
		return 'faq_sections';
	}


	public function rules()
	{
		return array(
			array('name, lang', 'required'),
			array('is_published', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>200),
			array('name', 'unique', 'className' => 'FaqSection', 'attributeName' => 'name'),
			array('id, name, is_published', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
			'faqs'     => array(self::HAS_MANY, 'Faq', 'section_id'),
			'language' => array(self::BELONGS_TO, 'Language', 'lang')
		);
	}


	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('is_published',$this->is_published);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}
}
