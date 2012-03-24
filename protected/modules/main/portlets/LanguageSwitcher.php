<?php
class LanguageSwitcher extends CWidget
{
    public function run()
    {
        $this->render('LanguageSwitcher', array(
            'langs' => Language::model()->findAll()
        ));
    }
}
