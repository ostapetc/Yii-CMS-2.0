<?php
 
class AuthObjectBehavior extends CActiveRecordBehavior
{
    public $roles;

    public function afterSave()
    {
        $model = $this->getOwner();
        $class = get_class($model);

        AuthObject::model()->deleteAllByAttributes(array(
            'object_id' => $model->id,
            'model_id'  => $class
        ));

        if (isset($_POST[$class]['roles']))
        {  
            foreach ($_POST[$class]['roles'] as $role)
            {
                $auth_object = new AuthObject();
                $auth_object->model_id  = $class;
                $auth_object->object_id = $model->id;
                $auth_object->role      = $role;
                $auth_object->save();
            }
        }

        return true;
    }
}
