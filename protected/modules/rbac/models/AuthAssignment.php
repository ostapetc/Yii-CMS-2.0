<?php
/** 
 * @property                 $itemname
 * @property                 $userid
 * @property                 $bizrule
 * @property                 $data
 * @property                 $newAttachedModel
 * @property mixed           $related          the related object(s).
 * @property string          $attributeLabel   the attribute label
 * @property CActiveRelation $activeRelation   the named relation declared for this AR class. Null if the relation does not exist.
 * @property mixed           $attribute        the attribute value. Null if the attribute is not set or does not exist.
 * @property string          $error            the error message. Null is returned if no error.
 * @property CList           $eventHandlers    list of attached event handlers for the event
 * @property AuthItem        $role
 * 
 */

class AuthAssignment extends ActiveRecord
{
    public function name()
    {
        return 'Ассоциации ролей';
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'auth_assignments';
	}


	public function rules()
	{
		return array(
			array('itemname, userid', 'required'),
			array('itemname, userid', 'length', 'max' => 64),
			array('bizrule, data', 'safe'),
			array('itemname, userid, bizrule, data', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
			'role' => array(self::BELONGS_TO, 'AuthItem', 'itemname')
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('itemname', $this->itemname, true);
		$criteria->compare('userid', $this->userid, true);
		$criteria->compare('bizrule', $this->bizrule, true);
		$criteria->compare('data', $this->data, true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}


    public static function updateUserRole($user_id, $role)
    {
        $assignment = AuthAssignment::model()->findByAttributes(array('userid' => $user_id));
        if (!$assignment)
        {
            $assignment = new AuthAssignment();
            $assignment->userid = $user_id;
        }

        $assignment->itemname = $role;
        $assignment->save();
    }
}
