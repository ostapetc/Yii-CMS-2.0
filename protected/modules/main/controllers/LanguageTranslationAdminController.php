<?php

class LanguageTranslationAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'Manage' => 'Управление переводами'
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
}
