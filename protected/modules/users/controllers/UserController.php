<?

class UserController extends ClientController
{
    const ERROR_PASSWORD_RECOVER_AUTH = 'Вы не можете восстановить пароль будучи авторизованным!';

    public $user;


    public static function actionsTitles()
    {
        return array(
            'view'                   => t('Страница пользователя'),
            'update'                 => t('Редактирование личных данных'),
            'registration'            => t('Регистрация'),
            'activateAccount'        => t('Активация аккаунта'),
            'activateAccountRequest' => t('Запрос на активацию аккаунта'),
            'updateSelfData'         => t('Редактирование личных данных'),
            'index'                  => t('Люди'),
            'getUserId'              => t('Получить User ID')
        );
    }


    public function sidebars()
    {
        return array(
            array(
                'actions'  => array(
                    'view',
                    'updateSelfData'
                ),
                'sidebars' => array(
                    array(
                        'type' => 'widget',
                        'class' => 'application.modules.users.portlets.UserPageSidebar',
                    ),
                    array(
                        'type' => 'widget',
                        'class' => 'application.modules.users.portlets.OwnerPageSidebar'
                    )
                ),
            ),
            array(
                'actions' => array(
                    'index'
                ),
                'sidebars' => array(
                    array(
                        'type' => 'widget',
                        'class' => 'application.modules.users.portlets.UserFilterSidebar'
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
                'label'   => t('Мой профиль'),
                'url'     => array('/users/user/view', 'id' => Yii::app()->user->id),
                'visible' => !Yii::app()->user->isGuest
            ),
            array(
                'label'   => t('Редактировать личные данные'),
                'url'     => array("/users/user/updateSelfData"),
                'visible' => !Yii::app()->user->isGuest
            )
        );
    }


    /**
     * TODO: не работает капча
     * TODO: не проходит валидация по birthdate 18.9.1985, нужно чтобы было в календаре 18.09.1985
     * TODO
     */
    public function actionRegistration()
    {
        $user = new User(User::SCENARIO_REGISTRATION);
        $form = new Form('users.RegistrationForm', $user);

        $this->performAjaxValidation($user);

        if ($form->submitted() && $user->validate())
        {
            $user->password      = md5($user->password);
            $user->activate_date = new CDbExpression('NOW()');
            $user->throwIfErrors();
            $user->save(false);

            Yii::app()->user->setFlash('success', 'Вы успешно зарегистрированы');

            $this->redirect('/');
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


    public function actionView($id)
    {
        $this->page_title = '';
        $model = $this->loadModel($id);

        $this->render('view', array(
            'model' => $model
        ));
    }


    public function actionUpdateSelfData()
    {
        if (Yii::app()->user->isGuest)
        {
            $this->redirect(array('/users/session/create'));
        }
        $user = $this->loadModel(Yii::app()->user->id);

        $form = new Form('users.SelfDataForm', $user);
        $user->scenario = User::SCENARIO_UPDATE_SELF_DATA;

        $this->performAjaxValidation($user);
        if ($form->submitted() )
        {
            $user->save();;
            $this->redirect($user->url);
        }


        $this->render('updateSelfData', array(
            'model' => $user,
            'form' => $form
        ));
    }


    public function actionIndex()
    {
        $model = new User(User::SCENARIO_USER_SEARCH);
        $model->unsetAttributes();

        if (isset($_GET['User']))
        {
            $model->attributes = $_GET['User'];
        }

        $criteria = new CDbCriteria();
        $criteria->compare('name', trim($model->name), true);
        $criteria->compare('email', trim($model->email), true);

        $data_provider = new CActiveDataProvider('User', array(
            'criteria' => $criteria
        ));

        $this->render('index', array(
            'data_provider' => $data_provider
        ));
    }
}


