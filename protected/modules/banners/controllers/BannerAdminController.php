<?php

class BannerAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'View'         => 'Просмотр банера',
            'Create'       => 'Создание банера',
            'Update'       => 'Редактирование банера',
            'Delete'       => 'Удаление банера',
            'Manage'       => 'Управление банерами',
            'MovePosition' => 'Изменение приоритета банера'
        );
    }


    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }


    public function actionCreate($is_big)
    {
        $scenario = $is_big == 1 ? Banner::SCENARIO_BIG_BANNER : Banner::SCENARIO_CREATE;

        $model = new Banner($scenario);
        $this->performAjaxValidation($model);

        $form = $is_big == 1 ? 'BannerGigForm' : 'BannerForm';
        $form = new BaseForm('banners.' . $form, $model);

        if ($form->submitted('submit'))
        {
            $model              = $form->model;
            $model->date_active = $_POST['Banner']['date_active'];
            $model->is_big      = $is_big;

            if ($model->save())
            {
                $this->redirect(array(
                    'view',
                    'id' => $model->id
                ));
            }
        }

        $this->render('create', array(
            'form'   => $form,
            'is_big' => $is_big
        ));
    }


    public function actionUpdate($id)
    {
        $model           = $this->loadModel($id);
        $model->scenario = Banner::SCENARIO_UPDATE;

        $this->performAjaxValidation($model);
        $form = new BaseForm('banners.BannerForm', $model);

        if ($form->submitted('submit'))
        {
            $model              = $form->model;
            $model->date_active = $_POST['Banner']['date_active'];

            if (isset($_POST['Banner']['roles']))
            {
                $model->roles = $_POST['Banner']['roles'];
            }

            if ($model->save())
            {
                $this->redirect(array(
                    'view',
                    'id' => $model->id
                ));
            }
        }


        $this->render('update', array(
            'form' => $form,
        ));
    }


    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest)
        {
            $this->loadModel($id)->delete();

            if (!isset($_GET['ajax']))
            {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        }
        else
        {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }


    public function actionManage($is_big)
    {
        $model = new Banner('search');
        $model->unsetAttributes();
        if (isset($_GET['Banner']))
        {
            $model->attributes = $_GET['Banner'];
        }

        $this->render('manage', array(
            'model'  => $model,
            'is_big' => $is_big
        ));
    }


}
