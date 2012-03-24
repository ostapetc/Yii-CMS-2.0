<?php

class UserAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "Login"  => "Авторизация",
            "Manage" => "Управление пользователями",
            "View"   => "Просмотр пользователя",
            "Create" => "Добавление пользователя",
            "Update" => "Редактирование пользователя",
            "Delete" => "Удаление пользователя"
        );
    }


    public function actionLogin()
    {
        $this->layout = '//layouts/admin/login';

        if (!Yii::app()->user->isGuest)
        {
            throw new CException(t('Вы уже авторизованы!'));
        }

        $model = new User(User::SCENARIO_LOGIN);

        $form = new BaseForm('users.LoginForm', $model);
        $form->action = '';
        $form->cancel_button_show = false;

        unset($form->activeForm['enableAjaxValidation']);
        unset($form->activeForm['clientOptions']);

        $params = array(
            "model"      => $model,
            "error_code" => null,
            "form"       => $form
        );

        if (isset($_POST["User"]))
        {
            $model->attributes = $_POST["User"];
            if ($model->validate())
            {
                $remember_me =
                    isset($_POST["User"]["remember_me"]) && $_POST["User"]["remember_me"] ? true : false;

                $identity = new UserIdentity($_POST["User"]["email"], $_POST["User"]["password"], $remember_me);

                if ($identity->authenticate(true))
                {
                    $this->redirect(isset($_GET['redirect']) ? base64_decode($_GET['redirect']) : "/content/pageAdmin/manage");
                }
                else
                {
                    $params["error_code"] = $identity->errorCode;
                }
            }
        }

        $this->render("login", $params);
    }


    public function actionManage()
    {
        $model = new User('search');
        $model->unsetAttributes();

        if (isset($_GET['User']))
        {
            $model->attributes = $_GET['User'];
        }

        $this->render('manage', array(
            'model' => $model,
        ));
    }


    public function actionView($id)
    {
        $this->render('view', array(
            'model'=> $this->loadModel($id),
        ));
    }


    public function actionCreate()
    {
        $model           = new User;
        $model->scenario = 'Create';

        $form = new BaseForm('users.UserForm', $model);

        unset($form->elements['captcha']);

        $this->performAjaxValidation($model);
        if ($form->submitted('submit'))
        {
            $model = $form->model;
            if ($model->validate())
            {
                $model->password = md5($model->password);
                $model->save(false);

                $assignment           = new AuthAssignment();
                $assignment->itemname = $_POST['User']['role'];
                $assignment->userid   = $model->id;
                $assignment->save();

                $this->redirect(array(
                    'view',
                    'id' => $model->id
                ));
            }
        }

        $this->render('create', array('form' => $form));
    }


    public function actionUpdate($id)
    {
        $model             = $this->loadModel($id);
        $model->password_c = $model->password;
        $model->scenario   = 'Update';

        $old_password = $model->password;

        $form = new BaseForm('users.UserForm', $model);

        unset($form->elements['captcha']);

        $this->performAjaxValidation($model);
        if ($form->submitted('submit'))
        {
            $model = $form->model;
            if ($model->validate())
            {
                if ($_POST['User']['password'] != $old_password)
                {
                    $model->password = md5($model->password);
                }

                $model->save(false);

                AuthAssignment::updateUserRole($model->id, $_POST['User']['role']);

                Implex::refreshXLS(get_class($model));

                $this->redirect('view', array(
                    'id'=> $model->id
                ));
            }
        }

        $this->render('update', array(
            'form' => $form,
        ));
    }


    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        $model->delete();

        if (!isset($_GET['ajax']))
        {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }

        Implex::refreshXLS(get_class($model));
    }
}
