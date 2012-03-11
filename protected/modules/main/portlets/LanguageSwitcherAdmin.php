<?php

class LanguageSwitcherAdmin extends  Portlet
{
    public function renderContent()
    {
        if (Yii::app()->params['multilanguage_support'] == false)
        {
            return false;
        }
        $langs = Language::model()->findAll(array('order' => "id='ru' DESC"));
        if (count($langs) > 1)
        {
            $this->render('LanguageSwitcherAdmin', array('langs' => $langs));
        }
    }
}
