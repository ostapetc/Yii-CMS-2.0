<?php
/** 
 * @property                 $id
 * @property                 $user_id
 * @property                 $title
 * @property                 $module
 * @property                 $controller
 * @property                 $action
 * @property                 $date_create
 * @property                 $popularModules
 * @property                 $newAttachedModel
 * @property mixed           $related          the related object(s).
 * @property string          $attributeLabel   the attribute label
 * @property CActiveRelation $activeRelation   the named relation declared for this AR class. Null if the relation does not exist.
 * @property mixed           $attribute        the attribute value. Null if the attribute is not set or does not exist.
 * @property string          $error            the error message. Null is returned if no error.
 * @property CList           $eventHandlers    list of attached event handlers for the event
 * @property User            $user
 * 
 */

class SiteAction extends ActiveRecord
{
    const PAGE_SIZE = 10;


    public function name()
    {
        return 'Действия сайта';
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'site_actions';
	}


	public function rules()
	{
		return array(
			array('title, module, controller, action', 'required'),
			array('user_id', 'length', 'max' => 11),
			array('title', 'length', 'max' => 200),
			array('module, controller, action', 'length', 'max' => 50),

			array('id, user_id, title, module, controller, action, date_create', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
		    "user" => array(self::BELONGS_TO, 'User', 'user_id')
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id, true);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('module', $this->module, true);
		$criteria->compare('controller', $this->controller, true);
		$criteria->compare('action', $this->action, true);
		$criteria->compare('date_create', $this->date_create, true);
        $criteria->order = 'date_create DESC';

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}
	
	
	public function getPopularModules($limit) 
	{
        $modules = array();
		
		$sql = "SELECT module FROM (
									SELECT module, MAX(date_create) AS max_date  
										   FROM " . $this->tableName() . " 
 									       WHERE user_id = " . Yii::app()->user->id . "
										   GROUP BY module
								   ) AS " . $this->tableName() . " 
							  ORDER BY " . $this->tableName() . ".max_date DESC 
							  LIMIT {$limit}";
			
	    $result = Yii::app()->db->createCommand($sql)->queryAll();
	    
        foreach ($result as $data)
        {
            $modules[]  = ucfirst($data["module"]) . "Module";
        }		    
      
        return $modules;	
	}
}
