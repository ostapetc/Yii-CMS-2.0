<?php
class LanguageSwitcher extends CWidget
{
    public function run()
    {
        if (Yii::app()->params['multilanguage_support'] == false)
        {
            return false;
        }
        $this->render('LanguageSwitcher', array(
            'langs' => Language::model()->findAll()
        ));
    }
}
