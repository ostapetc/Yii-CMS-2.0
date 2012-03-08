<?php
 
class WebUser extends CWebUser
{
    private $_model = null;

    private static $_role;


    public function getRole()
    {	
        if (self::$_role == null)
        {
            if($user = $this->getModel())
            {
                self::$_role = $user->role->name;
            }
            else
            {
                self::$_role = AuthItem::ROLE_GUEST;
            }
        }

        return self::$_role;
    }


    public static function setRole($role)
    {
        self::$_role = $role;
    }


    public function isRootRole()
    {
        if($user = $this->getModel())
        {
            return $user->isRootRole();
        }
    }


    public function getModel()
    {
        if (!$this->isGuest && $this->_model === null)
        {
            $this->_model = User::model()->findByPk($this->id);
        }

        return $this->_model;
    }

    public function checkAccess($item_name,$params=array(),$allowCaching=true)
    {
        if (isset(Yii::app()->user->role) && Yii::app()->user->role == AuthItem::ROLE_ROOT)
        {
            return true;
        }

        $auth_item = AuthItem::model()->findByPk($item_name);

        if (!$auth_item)
        {
            Yii::log("Задача $item_name не найдена!");
            return false;
        }

        if ($auth_item->allow_for_all)
        {
            return true;
        }

        if ($auth_item->tasks)
        {
            foreach ($auth_item->tasks as $task)
            {
                return $task->allow_for_all ? true : parent::checkAccess($task->name);
            }
        }
        else
        {
            return parent::checkAccess($auth_item->name);
        }

    }

}
