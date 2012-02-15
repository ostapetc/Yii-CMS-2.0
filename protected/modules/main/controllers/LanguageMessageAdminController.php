<?php

class LanguageMessageAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'Manage' => 'Управление переводами',
            'Update' => 'Редактирование переводов',
            'Create' => 'Добавление переводов',
            'D' => 'Удаление переводов'
        );
    }


    public function actionManage()
    {
        $model = new LanguageMessage(ActiveRecordModel::SCENARIO_SEARCH);

        $this->render('manage', array(
            'model'     => $model,
            'languages' => Language::getCachedArray()
        ));
    }


    public function actionCreate()
    {
        $language_message = new LanguageMessage();

        $form = new BaseForm('main.LanguageTranslationForm', $language_message);

        if (isset($_POST['LanguageMessage']))
        {
            $language_message->attributes   = $_POST['LanguageMessage'];
            $language_message->translations = $_POST['LanguageMessage']['translations'];
            if ($language_message->save())
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
        $language_message = $this->loadModel($id);

        $form = new BaseForm('main.LanguageTranslationForm', $language_message);

        if (isset($_POST['LanguageMessage']))
        {
            $language_message->attributes   = $_POST['LanguageMessage'];
            $language_message->translations = $_POST['LanguageMessage']['translations'];
            if ($language_message->save())
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
        $this->loadModel($id)->delete();
        if (!isset($_POST['ajax']))
        {
            $this->redirect(array('manage'));
        }
    }


    public function loadModel($id)
    {
        $model = LanguageMessage::model()->findByPk($id);
        if (!$model)
        {
            $model->pageNotFound();
        }

        return $model;
    }
}
