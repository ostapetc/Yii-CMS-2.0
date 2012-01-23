<?php

class PageBlock extends ActiveRecordModel
{
    const PAGE_SIZE = 10;


    public function name()
    {
        return 'Блоки страниц';
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'pages_blocks';
	}


	public function rules()
	{
		return array(
			array('title, text, name, lang', 'required'),
			array('name', 'match', 'pattern' => '|^[a-z_]+$|', 'message' => 'только латиница и знак подчеркивания "_"'),
			array('title', 'length', 'max'=>250),
			array('title', 'groupUnique', 'group' => array('lang')),
            array('name', 'groupUnique', 'group' => array('lang')),
			array('id, title, text, date_create', 'safe', 'on' => 'search'),
		);
	}


    public function groupUnique($main_attr, $params)
    {
        if (!isset($params['group']))
        {
            throw new CException('Забыли указать параметр group в валидаторе groupUnique');
        }

        if (!is_array($params['group']) || !$params['group'])
        {
            throw new CException('Параметр group валидатора groupUnique должен являться непустым массивом');
        }

        $params['group'][] = $main_attr;

        $attrs = array();

        foreach ($params['group'] as $group_attr)
        {
            $attrs[$group_attr] = $this->$group_attr;
        }

        $exist = $this->findByAttributes($attrs);
        if ($exist)
        {
            if (isset($params['message']))
            {
                $message = $params['message'];
            }
            else
            {
                $all_labels = $this->attributeLabels();

                $labels = array();
                foreach (array_keys($attrs) as $attr)
                {
                    $labels[] = $all_labels[$attr];
                }

                $message = "Поля: " . implode(', ', $labels) . ' в сочетании должны быть уникальны!';
            }
    
            $this->addError($main_attr, Yii::t('main', $message));
        }
    }


	public function relations()
	{
		return array(
		    'language' => array(self::BELONGS_TO, 'Language', 'lang')
		);
	}


	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('date_create',$this->date_create,true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}


    public function getText($name)
    {
        $block = $this->findByAttributes(array("name" => $name));
        if ($block)
        {
            $text = $block["text"];

        	if (RbacModule::isAllow('PageBlockAdmin_Update'))
        	{   
				$text.= "&nbsp; <a href='/content/pageBlockAdmin/update/id/{$block['id']}' class='admin_link'>Редактировать</a>";
        	}
        
        	return $text;
        }
    }
}
