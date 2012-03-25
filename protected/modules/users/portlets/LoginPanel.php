<?
class LoginPanel extends Widget
{
    public $cache_id;

    public function init()
    {
        parent::init();
        $this->cache_id = Yii::app()->user->isGuest ? get_class($this) : null;
    }

    public function run()
    {
        if (Yii::app()->user->isGuest)
        {
            $login_form    = new Form('users.LoginForm', new User(User::SCENARIO_LOGIN));
            $register_form = new Form('users.RegistrationForm', new User(User::SCENARIO_REGISTRATION));
            $forgot_form   = new Form('users.PasswordRecoverRequestForm', new User(User::SCENARIO_CHANGE_PASSWORD_REQUEST));


            $title = 'Вход';

            $this->render('LoginPanel', array(
                'title'          => $title,
                'login_form'     => $login_form,
                'register_form'  => $register_form,
                'forgot_form'    => $forgot_form,
            ));
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