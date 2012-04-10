<?
class LoginPanel extends Widget
{
    public function init()
    {
        parent::init();
    }


    public function run()
    {
        if (Yii::app()->user->isGuest)
        {
            $cache_id = get_class($this);
            $res = Yii::app()->cache->get($cache_id);
            if ($res === false)
            {
                $login_form    = new Form('users.LoginForm', new User(User::SCENARIO_LOGIN));
                $register_form = new Form('users.RegistrationForm', new User(User::SCENARIO_REGISTRATION));
                $forgot_form   = new Form('users.PasswordRecoverRequestForm', new User(User::SCENARIO_CHANGE_PASSWORD_REQUEST));


                $title = 'Вход';

                $res = $this->render('LoginPanel', array(
                    'title'          => $title,
                    'login_form'     => $login_form,
                    'register_form'  => $register_form,
                    'forgot_form'    => $forgot_form,
                ), true);
                Yii::app()->cache->set($cache_id, $res);
            }
            echo $res;
        }
        else
        {
            $content = 'Привет, ' . Yii::app()->user->model->email;
            $title   = 'Кабинет';
            $this->render('Cabinet', array(
                'content'=> $content,
                'title'  => $title
            ));
        }
    }
}