<?php

class Article extends ActiveRecordModel
{
    const PAGE_SIZE = 10;

    public function name()
    {
        return 'Статьи';
    }


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['FileManager'] = array(
            'class' => 'application.components.activeRecordBehaviors.AttachmentBehavior',
            'attached_model' => 'FileManager'
        );

        return $behaviors;
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'articles';
	}
	
	
	public function scopes() 
	{
		return array(
			'last'   => array('order' => 'date DESC'),
		);
	}
	

	public function rules()
	{
		return array(
			array('title, text, section_id, lang', 'required'),
			array('date', 'type', 'type' => 'date', 'dateFormat' => 'dd.mm.yyyy'),
			array('title', 'length', 'max' => 400),
			array('title, text, date, date_create', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
            'section'  => array(self::BELONGS_TO, 'ArticleSection', 'section_id'),
			'language' => array(self::BELONGS_TO, 'Language', 'lang')
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('title', $this->title, true);
		$criteria->compare('text', $this->text, true);
		$criteria->compare('date', $this->date, true);
		$criteria->compare('date_create', $this->date_create, true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}
	
	
	public function beforeSave() 
	{
		if (parent::beforeSave()) 
		{
			if (!$this->date) 
			{
				$this->date = date("Y-m-d");
			}
			
			return true;
		}
	}


    public function getContent()
    {
        if (RbacModule::isAllow('ArticleAdmin_Update'))
        {
            $this->text.= "<br/> <a href='{$this->updateUrl}' class='admin_link'>Редактировать</a>";
        }

        return $this->text;
    }


    public function getUpdateUrl()
    {
        return "/articles/articleAdmin/update/id/{$this->id}";
    }
}
