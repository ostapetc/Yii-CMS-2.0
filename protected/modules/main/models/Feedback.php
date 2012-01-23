<?php

class Feedback extends ActiveRecordModel
{
    const PAGE_SIZE = 10;


    public function name()
    {
        return 'Сообщения обратной связи';
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'feedback';
	}


	public function rules()
	{
		return array(
			array('first_name, last_name, patronymic, email, position, company, phone, comment', 'required'),
            array('first_name, last_name, patronymic, position','length', 'max' => 40),
            array('first_name, last_name, patronymic','RuLatAlphaValidator'),
            array('company, position', 'RuLatAlphaSpacesValidator'),
            array('company', 'length', 'max' => 80),
			array('email', 'length', 'max' => 80),
            array('phone', 'length', 'max' => 50),
            array('phone','PhoneValidator'),
			array('email', 'email'),
            array('comment', 'length', 'max' => 1000),
            array('first_name, last_name, patronymic, position, company, comment', 'filter', 'filter' => 'trim'),
			array('first_name, last_name, patronymic, position, company, comment', 'filter', 'filter' => 'strip_tags'),
            array('first_name, last_name, patronymic, position, company, email, date_create', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
		);
	}


	public function search()
	{
        $alias = $this->getTableAlias();
		$criteria=new CDbCriteria;
		$criteria->compare($alias.'.first_name',$this->first_name,true);
        $criteria->compare($alias.'.last_name',$this->last_name,true);
        $criteria->compare($alias.'.patronymic',$this->patronymic,true);
        $criteria->compare($alias.'.company',$this->company,true);
        $criteria->compare($alias.'.phone',$this->phone,true);
        $criteria->compare($alias.'.position',$this->position,true);
		$criteria->compare($alias.'.email',$this->email,true);
		$criteria->compare($alias.'.date_create',$this->date_create,true);

        $criteria->order = $alias.'.date_create DESC';

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}
}
