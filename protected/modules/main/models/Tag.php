<?php
/** 
 * @property                 $id
 * @property                 $name
 * @property                 $string
 * @property                 $newAttachedModel
 * @property mixed           $related          the related object(s).
 * @property string          $attributeLabel   the attribute label
 * @property CActiveRelation $activeRelation   the named relation declared for this AR class. Null if the relation does not exist.
 * @property mixed           $attribute        the attribute value. Null if the attribute is not set or does not exist.
 * @property string          $error            the error message. Null is returned if no error.
 * @property CList           $eventHandlers    list of attached event handlers for the event
 * 
 */

class Tag extends ActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'tags';
	}


    public function name()
    {
        return 'Теги';
    }


	public function rules()
	{
		return array(
			array('name', 'required'),
			array('name', 'unique'),
            array('name', 'filter', 'filter' => 'strip_tags'),
		);
	}


	public function relations()
	{
		return array();
	}


    public function search()
   	{
   		$criteria = new CDbCriteria;
   		$criteria->compare('name', $this->object_id, true);

   		return new ActiveDataProvider(get_class($this), array(
   			'criteria' => $criteria
   		));
   	}


    public static function getString($model_id, $object_id)
    {
        $sql = "SELECT GROUP_CONCAT(tags.name SEPARATOR  ', ') AS tags_string
                       FROM " . Tag::tableName() . " tags
                       INNER JOIN " . TagRel::tableName() . " tags_rels
                           ON tags_rels.tag_id     = tags.id       AND
                               tags_rels.object_id = {$object_id} AND
                               model_id            = '{$model_id}'";

       return Yii::app()->db->createCommand($sql)->queryScalar();
    }

}