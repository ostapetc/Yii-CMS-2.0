<?php
/** 
 * @property                 $info
 * @property                 $languageName
 * @property CComponent      $owner            the owner component that this behavior is attached to.
 * @property boolean         $enabled          whether this behavior is enabled
 * @method   AuthItemChild   published()
 * @method   AuthItemChild   sitemap()
 * @method   AuthItemChild   ordered()
 * @method   AuthItemChild   last()
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