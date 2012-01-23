<?php

class LanguageSwitcher extends Portlet
{
    public function renderContent()
    {
        $this->render('LanguageSwitcher', array(
            'langs' => Language::model()->findAll()
        ));
    }
}
