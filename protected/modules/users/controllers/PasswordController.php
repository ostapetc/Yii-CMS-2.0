<?php

/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 07.12.12
 * Time: 16:27
 * To change this template use File | Settings | File Templates.
 */

class PasswordController extends ClientController
{
    public static function actionsTitles()
    {
        return [
            'update'        => t('Смена пароля'),
            'updateRequest' => t('Запрос на смену пароля')
        ];
    }


    public function updateRequestAction()
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
}
