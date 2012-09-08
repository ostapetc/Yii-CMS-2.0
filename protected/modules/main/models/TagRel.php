<?php
/** 
 * 
 * !Attributes - атрибуты БД
 * @property                 $id
 * @property                 $tag_id
 * @property                 $object_id
 * @property                 $model_id
 * 
 * !Accessors - Геттеры и сеттеры класа и его поведений
 * @property                 $errorsFlatArray
 * 
 * !Scopes - именованные группы условий, возвращают этот АР
 * @method   TagRel          published()
 * @method   TagRel          sitemap()
 * @method   TagRel          ordered()
 * @method   TagRel          last()
 * 
 */

class TagRel extends ActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'tags_rels';
	}


    public function name()
    {
        return 'Связи с тегами';
    }


	public function rules()
	{
		return array(
			array('model_id, object_id, tag_id', 'required'),
			array('object_id, tag_id', 'length', 'max' => 11),
            array('object_id, tag_id', 'numerical', 'integerOnly' => true),
            array('model_id', 'length' , 'max' => 50)
		);
	}


	public function relations()
	{
		return array();
	}
}
