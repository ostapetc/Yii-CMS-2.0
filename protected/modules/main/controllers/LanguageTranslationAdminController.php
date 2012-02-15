<?php

class LanguageTranslationAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'Manage' => 'Управление переводами',
            'Update' => 'Редактирование переводов'
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


    public function actionUpdate($id)
    {
        $language_message = LanguageMessage::model()->findByPk($id);
        if (!$language_message)
        {
            $this->pageNotFound();
        }

        $model = new LanguageMessage(ActiveRecordModel::SCENARIO_UPDATE);
        $form  = new BaseForm('main.LanguageTranslationForm', $model);

        $this->render('update', array(
            'form' => $form
        ));
    }
}
