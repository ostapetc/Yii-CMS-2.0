<?php
/** 
 * @property                 $parent
 * @property                 $child
 * @property                 $newAttachedModel
 * @property mixed           $related          the related object(s).
 * @property string          $attributeLabel   the attribute label
 * @property CActiveRelation $activeRelation   the named relation declared for this AR class. Null if the relation does not exist.
 * @property mixed           $attribute        the attribute value. Null if the attribute is not set or does not exist.
 * @property string          $error            the error message. Null is returned if no error.
 * @property CList           $eventHandlers    list of attached event handlers for the event
 * 
 */

class AuthItemChild extends ActiveRecord
{
    public function name()
    {
        return 'Дети элементов авторизации';
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'auth_items_childs';
	}


	public function rules()
	{
		return array(
			array('parent, child', 'required'),
			array('parent, child', 'length', 'max' => 64),
			array('parent, child', 'safe', 'on' => 'search'),
		);
	}
}