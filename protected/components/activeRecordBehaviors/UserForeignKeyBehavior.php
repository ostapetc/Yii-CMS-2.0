<?
 
class UserForeignKeyBehavior extends  ActiveRecordBehavior
{
    public function beforeValidate($event)
    {
        $model = $this->getOwner();

    	if (array_key_exists('user_id', $model->attributes) && $model->user_id === null)
    	{
    		$model->user_id = Yii::app()->user->id;
    	}
    }
}
