<?php
/** 
 * @property                 $id
 * @property                 $level
 * @property                 $category
 * @property                 $logtime
 * @property                 $message
 * @property                 $newAttachedModel
 * @property mixed           $related          the related object(s).
 * @property string          $attributeLabel   the attribute label
 * @property CActiveRelation $activeRelation   the named relation declared for this AR class. Null if the relation does not exist.
 * @property mixed           $attribute        the attribute value. Null if the attribute is not set or does not exist.
 * @property string          $error            the error message. Null is returned if no error.
 * @property CList           $eventHandlers    list of attached event handlers for the event
 * 
 */

class Log extends ActiveRecord
{
    const PAGE_SIZE = 10;


    public function name()
    {
        return 'Логи';
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'log';
	}


	public function rules()
	{
		return array(
			array('level, category', 'length', 'max'=>128),
			array('message', 'safe'),
			array('id, level, category, logtime, message', 'safe', 'on'=>'search'),
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
		$criteria->compare('id',$this->id);
		$criteria->compare('level',$this->level,true);
		$criteria->compare('category',$this->category,true);
		$criteria->compare('logtime',$this->logtime);
		$criteria->compare('message',$this->message,true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}
}