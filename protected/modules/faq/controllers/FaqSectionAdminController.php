<?php

class FaqSectionAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "View"   => "Просмотр раздела вопросов",
            "Create" => "Добавление раздела вопросов",
            "Update" => "Редактирование раздела вопросов",
            "Delete" => "Удаление раздела вопросов",
            "Manage" => "Управление разделами вопросов",
        );
    }


    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }


    public function actionCreate()
    {
        $model = new FaqSection;

        $this->performAjaxValidation($model);
        $form = new BaseForm('faq.FaqSectionForm', $model);

        if ($form->submitted('submit'))
        {
            $model = $form->model;
            if ($model->save())
            {
                $this->redirect(array('manage'));
            }
        }

        $this->render('create', array(
            'form' => $form
        ));
    }


    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        $this->performAjaxValidation($model);
        $form = new BaseForm('faq.FaqSectionForm', $model);

        if ($form->submitted('submit'))
        {
            $model = $form->model;
            if ($model->save())
            {
                $this->redirect(array('manage'));
            }
        }

        $this->render('update', array(
            'form' => $form
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


    public function actionManage()
    {
        $model = new FaqSection('search');
        $model->unsetAttributes();
        if (isset($_GET['FaqSection']))
        {
            $model->attributes = $_GET['FaqSection'];
        }

        $this->render('manage', array(
            'model' => $model,
        ));
    }

}
