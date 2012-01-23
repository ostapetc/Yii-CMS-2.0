<?php

class Page extends ActiveRecordModel
{
    const PAGE_SIZE = 10;

    public $god;

    public function name()
    {
        return 'Страницы';
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'pages';
	}


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['MetaTag'] = array(
            'class' => 'application.components.activeRecordBehaviors.MetaTagBehavior'
        );
        return $behaviors;
    }


	public function rules()
	{
		return array(
			array('title, lang', 'required'),
			array('is_published', 'numerical', 'integerOnly' => true),
			array('url', 'length', 'max' => 250),
			array('title', 'length', 'max'=>200),
			array('text', 'safe'),
            array('meta_tags, god', 'safe'),
            array('title, url', 'filter', 'filter' => 'strip_tags'),
			array('id, title, url, text, is_published, date_create', 'safe', 'on'=>'search'),
		);
	}


	public function relations()
	{
		return array(
		    'language' => array(self::BELONGS_TO, 'Language', 'lang')
		);
	}


	public function search()
	{	
		$criteria = new CDbCriteria;
		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('is_published',$this->is_published);
		$criteria->compare('date_create',$this->date_create,true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}


    public function getHref()
    {
        $url = trim($this->url);
        if ($url)
        {
            if ($url[0] != "/")
                $url = "/page/{$url}";

            return $url;
        }
        else
        {
            return "/page/" . $this->id;
        }
    }


    public function beforeSave()
    {
        if (parent::beforeSave())
        {	
        	if ($this->url != '/') 
        	{
        		$this->url = trim($this->url, "/");
        	}
            
            return true;
        }
    }
    
    
    public function getContent() 
    {
    	$content = $this->text;

        if (RbacModule::isAllow('PageAdmin_Update'))
        {
            $content.= "<br/><a href='/content/pageAdmin/update/id/{$this->id}' class='admin_link'>Редактировать</a>";
        }
    	
    	return $content;
    }
}
