<?php

class BannerRole extends ActiveRecordModel
{
    const PAGE_SIZE = 10;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'banners_roles';
	}


    public function name()
    {
        return 'Роли банера';
    }


	public function rules()
	{
		return array(
			array('banner_id, role', 'required'),
			array('banner_id', 'length', 'max' => 11),
			array('role', 'length', 'max' => 64),

			array('id, banner_id, role', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
			'banner' => array(self::BELONGS_TO, 'Banners', 'banner_id'),
			'role0' => array(self::BELONGS_TO, 'AuthAssignment', 'role'),
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id, true);
		$criteria->compare('banner_id', $this->banner_id, true);
		$criteria->compare('role', $this->role, true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}
}