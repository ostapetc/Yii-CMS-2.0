<?php

class MetaTag extends ActiveRecordModel
{
    const PAGE_SIZE = 10;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'meta_tags';
	}


    public function name()
    {
        return 'Мета-теги';
    }


	public function rules()
	{
		return array(
			array('model_id', 'required'),
			array('object_id', 'length', 'max' => 11),
			array('model_id', 'length', 'max' => 50),
			array('title, keywords, description', 'length', 'max' => 300),
			array('date_update', 'safe'),
			array('object_id, model_id, title, keywords, description, date_create, date_update', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array();
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('object_id', $this->object_id, true);
		$criteria->compare('model_id', $this->model_id, true);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('keywords', $this->keywords, true);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('date_create', $this->date_create, true);
		$criteria->compare('date_update', $this->date_update, true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}


    public function html($object_id, $model_id)
    {
        $meta_tag = $this->findByAttributes(array(
            'object_id' => $object_id,
            'model_id'  => $model_id
        ));

        if (!$meta_tag)
        {
            return;
        }

        $html = "";

        $labels = $this->attributeLabels();

        $tags = array('title', 'keywords', 'description');

        foreach ($tags as $tag)
        {
            $html .= '<b>'.$labels[$tag].'</b>'.': '.$meta_tag->$tag.'<br/><br/>';
        }

        return $html;
    }


    public function getObject()
    {
        $models = AppManager::getModels();
        if (!isset($models[$this->model_id]))
        {
            return;
        }

        $object = ActiveRecordModel::model($this->model_id)->findByPk($this->object_id);
        if ($object)
        {
            return $object;
        }
        else
        {
            return '<span style="color:red">не существует</span>';
        }
    }


    public function getModelName()
    {
        $models = AppManager::getModels();
        if (isset($models[$this->model_id]))
        {
            return call_user_func(array($this->model_id, 'name'));
        }
        else
        {
            return '<span style="color:red">не существует</span>';
        }
    }
}