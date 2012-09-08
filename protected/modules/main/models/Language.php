<?php
/** 
 * @property                 $id
 * @property                 $name
 * @property                 $list
 * @property                 $newAttachedModel
 * @property mixed           $related          the related object(s).
 * @property string          $attributeLabel   the attribute label
 * @property CActiveRelation $activeRelation   the named relation declared for this AR class. Null if the relation does not exist.
 * @property mixed           $attribute        the attribute value. Null if the attribute is not set or does not exist.
 * @property string          $error            the error message. Null is returned if no error.
 * @property CList           $eventHandlers    list of attached event handlers for the event
 * 
 */

class Language extends ActiveRecord
{
    const PAGE_SIZE = 10;


    public function name()
    {
        return 'Языки';
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'languages';
	}


	public function rules()
	{
		return array(
			array('id, name', 'required'),
		    array('id', 'unique', 'className' => 'Language', 'attributeName' => 'id'),
		    array('name', 'unique', 'className' => 'Language', 'attributeName' => 'name'),
			array('id', 'LatAlphaValidator'),
			array('id', 'length', 'max' => 2, 'min' => 2),
			array('name', 'length', 'max' => 15),
			array('id, name', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id, true);
		$criteria->compare('name', $this->name, true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}


    public static function getList()
    {
        $languages = Yii::app()->cache->get('languages');
        if (!$languages)
        {
            $languages = ArrayHelper::extract(Language::model()->findAll(), 'id', 'name');
            Yii::app()->cache->set('languages', $languages);
        }

        return $languages;
    }


    //WTF? flash, parent::afterSave()
    public function afterSave()
    {
        if (parent::afterSave())
        {
            Yii::app()->cache->flush('languages');
        }

    }


    public function afterDelete()
    {
        Yii::app()->cache->flush('languages');
    }
}