<?php

class LanguagesBehavior extends CActiveRecordBehavior
{
    private function defineLanguage()
    {
        if (Yii::app()->controller instanceof AdminController)
        {
            return Yii::app()->language;
        }
        else
        {
            return Yii::app()->session["language"];
        }
    }


    public function language($language_id = null)
    {
        if (!$language_id)
        {
            $language_id = $this->defineLanguage();;
        }

        $criteria = $this->owner->getDbCriteria();
        $criteria->addCondition("language = '" . $language_id . "'");
        return $this->owner;
    }


    public function getLanguageName()
    {
        $languages = Language::getCachedArray();
        if (isset($languages[$this->owner->language]))
        {
            return $languages[$this->owner->language];
        }
    }
}
