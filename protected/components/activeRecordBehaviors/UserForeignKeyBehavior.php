<?php
 
class UserForeignKeyBehavior extends  CActiveRecordBehavior
{
    public function beforeValidate()
    {
        $model = $this->getOwner();
        
    	if (array_key_exists('user_id', $model->attributes) && $model->user_id === null)
    	{
    		$model->user_id = Yii::app()->user->id;
    	}
    }
}
