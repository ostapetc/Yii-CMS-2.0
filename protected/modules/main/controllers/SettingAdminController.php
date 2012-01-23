<?php

class SettingAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'View'   => 'Просмотр настройки',
            'Update' => 'Редактирование настройки',
            'Manage' => 'Управление настройками'
        );
    }


    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }


    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        $this->performAjaxValidation($model);
        $form = new BaseForm('main.SettingForm', $model);

        if ($form->submitted('submit'))
        {
            $model = $form->model;
            if ($model->save())
            {
                $this->redirect(array(
                    'view',
                    'id'=> $model->id
                ));
            }
        }

        $this->render('update', array(
            'form' => $form,
        ));
    }


    public function actionManage($module_id = null)
    {
        $model = new Setting('search');
        $model->unsetAttributes();

        if (isset($_GET['Setting']))
        {
            $model->attributes = $_GET['Setting'];
        }

        $params = array(
            'model' => $model
        );

        if ($module_id)
        {
            $params['module_id'] = $module_id;
            $params['module_name'] = AppManager::getModuleName($module_id);
        }

        $this->render('manage', $params);
    }

}
