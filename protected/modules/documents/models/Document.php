<?php

class Document extends ActiveRecordModel
{
    const PAGE_SIZE = 10;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'documents';
	}


    public function name()
    {
        return 'Документы';
    }


	public function rules()
	{
		return array(
			array('name, desc, date_publish, lang', 'required'),
			array('is_published', 'numerical', 'integerOnly' => true),
			array('name', 'length', 'max' => 500),

			array('name, is_published, date_publish, date_create', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
			'files'    => array(self::HAS_MANY, 'DocumentFile', 'document_id'),
			'language' => array(self::BELONGS_TO, 'Language', 'lang')
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('is_published', $this->is_published);
		$criteria->compare('date_publish', $this->date_publish, true);
		$criteria->compare('date_create', $this->date_create, true);
		$criteria->order = 'date_publish DESC';		

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}
	
	
	public function delete() 
	{
		foreach ($this->files as $file) 
		{
			$file->delete();
		}
		
		parent::delete();
	}


    public function getContent()
    {
        if (RbacModule::isAllow('DocumentAdmin_Update'))
        {
            $this->desc.= "<br/><a href='/documents/DocumentAdmin/update/id/{$this->id}' class='admin_link'>Редактировать</a>";
        }

        return $this->desc;
    }
}
