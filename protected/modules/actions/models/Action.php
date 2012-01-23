<?php

class Action extends ActiveRecordModel
{
    const PAGE_SIZE = 10;

	const IMG_DIR = 'upload/actions';

    const IMG_SMALL_WIDTH  = "80";
    const IMG_SMALL_HEIGHT = "80";
	const IMG_MID_WIDTH    = "130";
	const IMG_MID_HEIGHT   = "130";
    const IMG_BIG_WIDTH    = "450";


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'actions';
	}


    public function name()
    {
        return 'Мероприятия';
    }


	public function rules()
	{
		return array(
			array('name, place, desc, image, date, lang', 'required'),
			array('name', 'length', 'max' => 500),
			array('place', 'length', 'max' => 900),
			array('date', 'length', 'max' => 50),
			array(
				'image',
				'file',
				'types'      => 'jpg, jpeg, gif, png, tif',
				'allowEmpty' => true,
				'maxSize'    => 1024 * 1024 * 2.5,
				'tooLarge'   => 'Максимальный размер файла 2.5 Мб'
			),
			array('name, place, desc, image, date, date_create', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
			'files'    => array(self::HAS_MANY, 'ActionFile', 'action_id'),
			'language' => array(self::BELONGS_TO, 'Language', 'lang')
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('place', $this->place, true);
		$criteria->compare('desc', $this->desc, true);
		$criteria->compare('image', $this->image, true);
		$criteria->compare('date', $this->date, true);
		$criteria->compare('date_create', $this->date_create, true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}


    public function uploadFiles()
    {
        return array(
            'image' => array('dir' => self::IMG_DIR)
        );
    }
    
    
	public function delete() 
	{
		foreach ($this->files as $file) 
		{
			$file->delete();
		}
		
		parent::delete();
	}   
}
