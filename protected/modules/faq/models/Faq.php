<?php

class Faq extends ActiveRecordModel
{
    const PAGE_SIZE = 10;


    public function name()
    {
        return 'Вопросы и ответы';
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'faq';
	}


	public function rules()
	{
		return array(
		    array('first_name, email, lang', 'required', 'on' => 'ClientSide'),
			array('question', 'required'),
            array('first_name, last_name, patronymic, position','length', 'max' => 40),
            array('first_name, last_name, patronymic','RuLatAlphaValidator'),
			array('section_id, is_published', 'numerical', 'integerOnly'=>true),
			array('answer, date_create', 'safe'),
            array('company', 'length', 'max' => '80'),
            array('phone', 'PhoneValidator'),
            array('is_published, answer', 'unsafe', 'on' => 'ClientSide'),
            array(
                'first_name, last_name, patronymic, position, email, company, phone',
                'filter',
                'filter' => 'strip_tags'
            ),
            array('question', 'filter', 'filter' => 'strip_tags', 'on' => 'ClientSide'),
            array(
                'first_name, last_name, patronymic, position, email, question, answer, company, phone',
                'filter',
                'filter' => 'trim'
            ),
			array('first_name, last_name, patronymic, section_id, question, answer, is_published, date_create', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
			'section'  => array(self::BELONGS_TO, 'FaqSection', 'section_id'),
			'language' => array(self::BELONGS_TO, 'Language', 'lang')
		);
	}


	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('patronymic', $this->patronymic, true);
		$criteria->compare('section_id',$this->section_id);
		$criteria->compare('question',$this->question, true);
		$criteria->compare('answer',$this->answer, true);
		$criteria->compare('is_published',$this->is_published);
		$criteria->compare('date_create',$this->date_create, true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}
}
