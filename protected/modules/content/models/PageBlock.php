<?php

class PageBlock extends ActiveRecordModel
{
    const PAGE_SIZE = 10;


    public function name()
    {
        return t('Блоки страниц');
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
			array('title, text, constant, language', 'required'),
			array('constant', 'match', 'pattern' => '|^[A-Z_]+$|', 'message' => 'заглавными, латиница и знак подчеркивания "_"'),
			array('title', 'length', 'max'=>250),
			array('id, title, text, date_create', 'safe', 'on' => 'search'),
		);
	}


    public function groupUnique($main_attr, $params)
    {
        $exist = self::model()->findByAttributes(array(
            $main_attr       => $this->$main_attr,
            $params['group'] => $this->$params['group']
        ));

        if ($exist)
        {
            $labels = $this->attributeLabels();
            $this->addError($main_attr, 'Поле ' . $labels[$main_attr] . ' должно быть уникальным для одного языка!');
        }
    }


	public function relations()
	{
		return array(
		    'language_model' => array(self::BELONGS_TO, 'Language', 'language')
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


    public static function getText($constant)
    {
        return self::getContent($constant);
    }


    public static function getContent($constant)
    {
        $attrs = array();

        $block = PageBlock::model()->language()->findByAttributes(array("constant" => $constant));
        if ($block)
        {
            $text = $block["text"];

        	if (RbacModule::isAllow('PageBlockAdmin_Update'))
        	{
				$text.= "&nbsp; <a href='/content/pageBlockAdmin/update/id/{$block['id']}' class='btn btn-danger'>Редактировать</a>";
        	}

        	return $text;
        }
    }
}
