<?
 
class WebUser extends CWebUser
{
    private $_model = null;


    public function getRole()
    {
        if($user = $this->getModel())
        {
            return $user->role;
        }
        else
        {
            return User::ROLE_GUEST;
        }
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


    public function checkAccess($auth_item_name, $params = array(), $allow_caching = true)
    {
        return true;
        if (Yii::app()->user->isRootRole()) return true;

        $auth_item = AuthItem::model()->findByPk($auth_item_name);
        if ($auth_item && $auth_item['allow_for_all'])
        {
            return true;
        }

        return parent::checkAccess($auth_item_name, $params, $allow_caching);
    }


    public function __get($attribute)
    {
        try
        {
            return parent::__get($attribute);
        }
        catch (CException $e)
        {
            $model = $this->getModel();
            if ($model)
            {
                return $model->__get($attribute);
            }
            else
            {
                throw $e;
            }
        }
    }
}
