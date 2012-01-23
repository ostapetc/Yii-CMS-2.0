<?php

class MenuLink extends ActiveRecordModel
{
    const PAGE_SIZE = 10;

	public $max_order;


    public function name()
    {
        return 'Ссылки меню';
    }

	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'menu_links';
	}


	public function rules()
	{
		return array(
			array('menu_id, title, order, lang', 'required'),
			array('url', 'required', 'on' => 'pageRefNull'),
			array('order, is_visible', 'numerical', 'integerOnly' => true),
			array('page_id, menu_id', 'length', 'max' => 11),
			array('title', 'length', 'max' => 50),
			array('url', 'length', 'max' => 200),
			array('user_role, not_user_role', 'length', 'max' => 50),
			array('user_role', 'onlyOneRole'),
			array('title, url', 'filter', 'filter' => 'trim'),
			array('id, page_id, menu_id, title, url, user_role, order, is_visible', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
			'menu'     => array(self::BELONGS_TO, 'Menu', 'menu_id'),
			'page'     => array(self::BELONGS_TO, 'Page', 'page_id'),
            'childs'   => array(self::HAS_MANY, 'MenuLink', 'parent_id'),
            'visibleChilds'   => array(self::HAS_MANY, 'MenuLink', 'parent_id',
                'condition' => 'visibleChilds.is_visible=1'
            ),
            'parent'   => array(self::BELONGS_TO, 'MenuLink', 'parent_id'),
            'language' => array(self::BELONGS_TO, 'Language', 'lang')
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id, true);
		$criteria->compare('page_id', $this->page_id, true);
		$criteria->compare('menu_id', $this->menu_id, true);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('url', $this->url, true);
		$criteria->compare('user_role', $this->user_role, true);
		$criteria->compare('order', $this->order);
		$criteria->compare('is_visible', $this->is_visible);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}
	
	
	public function beforeSave() 
	{
		if (parent::beforeSave()) 
		{
			if ($this->url != '/') 
			{
				$this->url = trim($this->url, '/');
			}
			
			return true;
		}
	}
	
	
	public function onlyOneRole($attr) 
	{
		if (!empty($this->user_role) && !empty($this->not_user_role)) 
		{
			
			$this->addError($attr, 'Выберите только для кого видно или для всех кроме');
		}	
	}
	
	
	public function getHref() 
	{	
		if ($this->page) 
		{
			$url = $this->page->href;
		}
		else 
		{
			$url = $this->url;
		}
		
		if (mb_substr($url, 0, 1, 'utf-8') != '/') 
		{
			$url = '/' . $url;
		}
		
		return $url;
	}


    public function optionsTree($id = null, $menu_id, $result = array(), $spaces = 0, $parent_id = null)
    {
        $objects = $this->findAllByAttributes(array(
            'parent_id' => $parent_id,
            'menu_id'   => $menu_id
        ));

        foreach ($objects as $object)
        {
            if ($object->id == $id) continue;

            if ($object->parent_id === null)
            {
                $spaces = 0;
            }

            $result[$object->id] = str_repeat("_", $spaces) . $object->title;

            if ($object->childs)
            {
                $spaces+=2;

                $result = $this->optionsTree($id, $menu_id, $result, $spaces, $object->id);
            }
        }

        return $result;
    }
    
    
    public function isActive() 
    {
    	return $_SERVER['REQUEST_URI'] == $this->href;
    }
}
