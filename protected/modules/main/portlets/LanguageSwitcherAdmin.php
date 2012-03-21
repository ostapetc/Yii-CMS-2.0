<?php

class LanguageSwitcherAdmin extends  Portlet
{
    public function renderContent()
    {
        $langs = Language::model()->findAll(array('order' => "id='ru' DESC"));
        if (count($langs) > 1)
        {
            $this->render('LanguageSwitcherAdmin', array('langs' => $langs));
        }
    }
}
