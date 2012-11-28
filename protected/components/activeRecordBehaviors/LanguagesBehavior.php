<?

class LanguagesBehavior extends ActiveRecordBehavior
{
    public function setInfo(){}

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
        if (!Yii::app()->params->multilanguage_support)
        {
            return $this->owner;
        }

        if (!$language_id)
        {
            $language_id = $this->defineLanguage();
        }

        $field_exists = false;

        $meta = $this->owner->meta();
        foreach ($meta as $data)
        {
            if ($data['Field'] == 'language')
            {
                $field_exists = true;
                break;
            }
        }

        if (!$field_exists)
        {
            $msg = "У таблицы '" . $this->owner->tableName() . "' отсутствует поле 'language' <br/>";
            $msg .= "<a href='" . Yii::app()->createUrl('main/languageAdmin/createTableField', array('model' => get_class($this->owner))) . "'>создать данное поле в таблице</a>";

            throw new CHttpException(500, $msg);
        }

        $criteria = $this->owner->getDbCriteria();
        $criteria->addCondition("language = '" . $language_id . "'");
        return $this->owner;
    }


    public function getLanguageName()
    {
        $languages = Language::getList();
        if (isset($languages[$this->owner->language])) {
            return $languages[$this->owner->language];
        }
    }


    public function beforeFormInit($event)
    {
        if (!$event->sender->add_elements_from_behaviors)
        {
            return true;
        }

        $elements = $event->sender->getElements();
        $meta = $this->owner->meta();
        $languages = Language::getList();

        if (isset($meta['language']) && count($languages) > 1) {
            $elements['language'] = array(
                'type'  => 'dropdownlist',
                'items' => $languages
            );
        }

        $event->sender->setElements($elements);
    }

}
