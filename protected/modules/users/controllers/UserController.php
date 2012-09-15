<?

class UserController extends ClientController
{
    const ERROR_PASSWORD_RECOVER_AUTH = 'Вы не можете восстановить пароль будучи авторизованным!';

    public $user;


    public static function actionsTitles()
    {
        return array(
            "login"                  => t("Авторизация"),
            "logout"                 => t("Выход"),
            "view"                   => t("Страница пользователя"),
            "edit"                   => t("Редактирование личных данных"),
            "registration"           => t("Регистрация"),
            "activateAccount"        => t("Активация аккаунта"),
            "activateAccountRequest" => t("Запрос на активацию аккаунта"),
            "changePassword"         => t("Смена пароля"),
            "changePasswordRequest"  => t("Запрос на смену пароля"),
            "updateSelfData"         => t("Редактирование личных данных")
        );
    }


    public function sidebars()
    {
        return array(
            array(
                'actions'  => array('view', 'updateSelfData'),
                'sidebars' => array(
                    array(
                        'widget',
                        'application.modules.users.portlets.UserPageSidebar'
                    ),
                    array(
                        'widget',
                        'application.modules.users.portlets.OwnerPageSidebar'
                    )
                )
            )
        );
    }


    public function subMenuItems()
    {
        return array(
            array(
                'label'   => t('Активировать аккаунт'),
                'url'     => array('/users/user/activateAccountRequest'),
                'visible' => Yii::app()->user->isGuest
            ),
            array(
                'label'   => t('Забыли пароль?'),
                'url'     => array('/users/user/ChangePasswordRequest'),
                'visible' => Yii::app()->user->isGuest,
            ),
            array(
                'label'   => t('Редактировать личные данные'),
                'url'     => array("/users/user/updateSelfData"),
                'visible' => !Yii::app()->user->isGuest
            )
        );
    }


    public function actionLogin()
    {
        $model = new User(User::SCENARIO_LOGIN);

        $this->performAjaxValidation($model);

        $form = new Form('users.LoginForm', $model);

        if (isset($_POST['User']['email']) && isset($_POST['User']["password"]) && !isset($_POST['ajax']))
        {
            $model->attributes = $_POST['User'];

            if ($model->validate())
            {
                $identity = new UserIdentity($model->email, $model->password);
                if ($identity->authenticate())
                {
                    Yii::app()->user->setFlash('success', t('Вы успешно авторизованы'));

                    $this->redirect((isset($_GET['redirect']) && !empty($_GET['redirect'])) ? $_GET['redirect'] : '/');
                }
                else
                {
                    $auth_error = $identity->errorCode;
                    if ($auth_error == UserIdentity::ERROR_NOT_ACTIVE)
                    {
                        $auth_error.= '<br/>' . CHtml::link('Не пришло письмо? Активировать аккаунт повторно?', '/activateAccountReques');
                    }
                    else if ($auth_error == UserIdentity::ERROR_UNKNOWN)
                    {
                        $auth_error.= '<br/>' . CHtml::link('Восстановить пароль', 'changePasswordRequest');
                    }

                    Yii::app()->user->setFlash('error', $auth_error);

                    $this->redirect('/login');
                }
            }
        }

        $this->render('login', array(
            'form' => $form
        ));
    }


    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }


    /**
     * TODO: не работает капча
     * TODO: не проходит валидация по birthdate 18.9.1985, нужно чтобы было в календаре 18.09.1985
     * TODO
     */
    public function actionRegistration()
    {
        MailerTemplate::checkRequired(UsersModule::MAILER_TEMPLATE_REGISTRATION);
        Param::checkRequired(UsersModule::PARAM_REGISTRATION_DONE_MESSAGE);

        $user = new User(User::SCENARIO_REGISTRATION);
        $form = new Form('users.RegistrationForm', $user);

        $this->performAjaxValidation($user);

        if (isset($_POST['User']))
        {
            $user->attributes = $_POST['User'];
            if ($user->validate())
            {
                $user->password = md5($user->password);
                $user->generateActivateCode();
                $user->activate_date = new CDbExpression('NOW()');

                if ($user->save(false))
                {
                    $outbox = new MailerOutbox();
                    $outbox->user_id     = $user->id;
                    $outbox->template_id = MailerTemplate::model()->getIdByCode(UsersModule::MAILER_TEMPLATE_REGISTRATION);
                    $outbox->save();

                    $assignment = new AuthAssignment();
                    $assignment->itemname = AuthItem::ROLE_DEFAULT;
                    $assignment->userid   = $user->id;
                    $assignment->save();

                    Yii::app()->user->setFlash('success', Param::model()->getValue(UsersModule::PARAM_REGISTRATION_DONE_MESSAGE));

                    $this->redirect('/');
                }
            }
        }

        $this->render('registration', array('form' => $form));
    }


    public function actionActivateAccount($code)
    {
        $user = User::model()->findByAttributes(array('activate_code' => $code));
        if ($user)
        {
            if (strtotime($user->activate_date) + 24 * 3600 > time())
            {
                $user->activate_date = null;
                $user->activate_code = null;
                $user->status        = User::STATUS_ACTIVE;
                $user->save();

                Yii::app()->user->setFlash('success', 'Активация аккаунта прошла успешно. Вы можете авторизоваться.');
            }
            else
            {
                Yii::app()->user->setFlash('error', 'Срок действия активации аккаунта истек');
            }
        }
        else
        {
            Yii::app()->user->setFlash('error', 'C момента отправки письма прошло больше суток');
        }

        $this->redirect('/login');
    }


    public function actionActivateAccountRequest()
    {
        MailerTemplate::checkRequired(UsersModule::MAILER_TEMPLATE_ACTIVATION);

        $model = new User(User::SCENARIO_ACTIVATE_REQUEST);
        $form  = new Form('users.ActivateRequestForm', $model);

        $this->performAjaxValidation($model);

        if (isset($_POST['User']))
        {
            $model->attributes = $_POST['User'];
            if ($model->validate())
            {
                $user = User::model()->findByAttributes(array('email' => $_POST['User']['email']));
                if (!$user)
                {
                    Yii::app()->user->setFlash('error', 'Введенный вами Email не найден');
                }
                else
                {
                    switch ($user->status)
                    {
                        case User::STATUS_NEW:
                            $user->generateActivateCode();
                            $user->scenario      = User::SCENARIO_ACTIVATE_REQUEST;
                            $user->activate_date = new CDbExpression('NOW()');
                            $user->save();

                            $outbox = new MailerOutbox();
                            $outbox->user_id     = $user->id;
                            $outbox->template_id = MailerTemplate::model()->getIdByCode(UsersModule::MAILER_TEMPLATE_ACTIVATION);
                            $outbox->save();

                            Yii::app()->user->setFlash('success', 'На ваш Email отправлено письмо с дальнейшими инструкциями.');
                            break;

                        case User::STATUS_ACTIVE:
                            Yii::app()->user->setFlash('error', UserIdentity::ERROR_ALREADY_ACTIVE);
                            break;

                        case User::STATUS_BLOCKED:
                            Yii::app()->user->setFlash('error',UserIdentity::ERROR_BLOCKED);
                            break;
                    }
                }
            }
        }

        $this->render('activateAccountRequest', array(
            'form'  => $form
        ));
    }


    public function actionChangePasswordRequest()
    {
        MailerTemplate::checkRequired(UsersModule::MAILER_TEMPLATE_CHANGE_PASSWORD);

        $model = new User(User::SCENARIO_CHANGE_PASSWORD_REQUEST);
        $form  = new Form('users.ChangePasswordRequestForm', $model);

        $this->performAjaxValidation($model);

        if (isset($_POST['User']))
        {
            $model->attributes = $_POST['User'];
            if ($model->validate())
            {
                $user = User::model()->find("email = '{$model->email}'");
                if ($user)
                {
                    if ($user->status == User::STATUS_ACTIVE)
                    {
                        $user->password_recover_code = md5($user->password . $user->email . $user->id . time());
                        $user->password_recover_date = new CDbExpression('NOW()');
                        $user->save();

                        $outbox = new MailerOutbox();
                        $outbox->template_id = MailerTemplate::model()->getIdByCode(UsersModule::MAILER_TEMPLATE_CHANGE_PASSWORD);
                        $outbox->user_id     = $user->id;
                        $outbox->save();

                        Yii::app()->user->setFlash('success', 'На ваш Email отправлено письмо с дальнейшими инструкциями.');

                    }
                    else if ($user->status == User::STATUS_NEW)
                    {
                        Yii::app()->user->setFlash('error', UserIdentity::ERROR_NOT_ACTIVE);
                    }
                    else
                    {
                        Yii::app()->user->setFlash('error', UserIdentity::ERROR_BLOCKED);
                    }
                }
                else
                {
                    Yii::app()->user->setFlash('error', UserIdentity::ERROR_UNKNOWN_EMAIL);
                }

                $this->redirect($_SERVER['REQUEST_URI']);
            }
        }

        $this->render("changePasswordRequest", array(
            'form' => $form,
        ));
    }


    public function actionChangePassword($code)
    {
        $model = new User(User::SCENARIO_CHANGE_PASSWORD);
        $form  = new Form('users.ChangePasswordForm', $model);

        $this->performAjaxValidation($model);

        $user = User::model()->findByAttributes(array('password_recover_code' => $code));
        if (!$user)
        {
            Yii::app()->user->setFlash('error', 'Неверная ссылка изменения пароля');
            $this->redirect('/login');
        }
        else
        {
            if (strtotime($user->password_recover_date) + 24 * 3600 > time())
            {
                if ($form->submited())
                {
                    $user->password_recover_code = null;
                    $user->password_recover_date = null;
                    $user->password              = md5($_POST['User']['password']);
                    $user->save();

                    Yii::app()->user->setFlash('success', 'Ваш пароль успешно изменен, вы можете авторизоваться!');

                    $this->redirect('/login');
                }
            }
            else
            {
                Yii::app()->user->setFlash('error', 'С момента запроса на восстановление пароля прошло больше суток');
                $this->redirect('/login');
            }
        }

        $this->render('changePassword', array(
            'model' => $model,
            'form'  => $form
        ));
    }

    public function actionView($id)
    {
        $this->page_title = '';

        $model = $this->loadModel($id);

        $this->user = $model;

        $this->render('view', array(
            'model' => $model
        ));
    }

    public function actionUpdateSelfData()
    {
        if (Yii::app()->user->isGuest)
        {
            $this->redirect(array('/users/user/login'));
        }

        $user = $this->loadModel(Yii::app()->user->id);

        $form = new Form('users.SelfDataForm', $user);
        $user->scenario = User::SCENARIO_UPDATE_SELF_DATA;

        $this->performAjaxValidation($user);
        if ($form->submitted() && $user->save())
        {
            $this->redirect($user->url);
        }

        $this->render('updateSelfData', array(
            'model' => $user,
            'form' => $form
        ));
    }
}
