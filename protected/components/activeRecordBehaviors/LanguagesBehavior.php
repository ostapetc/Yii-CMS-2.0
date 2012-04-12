<?

class LanguagesBehavior extends ActiveRecordBehavior
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

        $meta = $this->owner->meta();
        if (!isset($meta['language']))
        {
            $msg = "У таблицы '" . $this->owner->tableName() . "' отсутствует поле 'language' <br/>";

            $msg.= "<a href='" . Yii::app()->createUrl('main/languageAdmin/createTableField', array('model' => get_class($this->owner))) . "'>создать данное поле в таблице</a>";
            throw new CHttpException($msg);
        }

        $criteria = $this->owner->getDbCriteria();
        $criteria->addCondition("language = '" . $language_id . "'");
        return $this->owner;
    }


    public function getLanguageName()
    {
        $languages = Language::getList();
        if (isset($languages[$this->owner->language]))
        {
            return $languages[$this->owner->language];
        }
    }


    public function beforeFormRender($event)
    {
        $elements = $event->sender->getElements();
        if (method_exists($this->owner, 'meta'))
        {
            $meta = $this->owner->meta();
            $languages = Language::getList();

            if (isset($meta['language']) && count($languages) > 1)
            {
                $elements['language'] = array(
                    'type'  => 'dropdownlist',
                    'items' => $languages
                );
            }
        }

        $event->sender->setElements($elements);

    }

}
