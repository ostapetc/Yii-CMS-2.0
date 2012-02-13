<?php

class UserIdentity extends CUserIdentity
{
    private $_id;

    private $remember_me;

    const ERROR_ACTIVATE_DATE  = "Вышла дата активации";
    const ERROR_ALREADY_ACTIVE = "Ваш аккаунт уже активирован!";
    const ERROR_UNKNOWN        = "Пользователь с введенными параметрами не найден!";
    const ERROR_BLOCKED        = "Ваш аккаунт заблокирован!";
    const ERROR_NOT_ACTIVE     = "Ваш аккаун не активирован!";


    public function __construct($email, $password, $remember_me = null)
    {
        parent::__construct($email, $password);
        $this->remember_me = $remember_me;
    }


    public function authenticate($admin_panel = false)
    {
        $user = User::model()->findByAttributes(array("email" => $this->username));

        if (!$user || $user->password != md5($this->password))
        {
            $this->errorCode = self::ERROR_UNKNOWN;
            return;
        }

        switch ($user->status)
        {
            case User::STATUS_ACTIVE:
                $this->errorCode = self::ERROR_NONE;
                $this->_id = $user->id;

                if ($this->remember_me)
                {	
                    Yii::app()->user->login($this, 3600 * 24 * 7);
                }
                else
                {
                    Yii::app()->user->login($this);
                }
                break;

            case User::STATUS_BLOCKED:
                $this->errorCode = self::ERROR_BLOCKED;
                break;

            case User::STATUS_NEW:
                $this->errorCode = self::ERROR_NOT_ACTIVE;
                break;
        }

        if (!$this->errorCode && $admin_panel)
        {
            WebUser::setRole($user->role);

            if (!RbacModule::isAllow('Admin_Main'))
            {
                Yii::app()->user->logout();
                $this->errorCode = self::ERROR_UNKNOWN;
                return false;
            }
        }
        
        return !$this->errorCode;
    }


    public function getId()
    {
        return $this->_id;
    }
}
