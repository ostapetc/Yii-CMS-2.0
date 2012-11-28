<?

if (!$this->model->isNewRecord)
{
    $translations = LanguageTranslation::model()->findAll('id = ' . $this->model->id);
    $translations = ArrayHelper::extract($translations, 'language', 'translation');
}

$elements = array(
    'message' => array('type' => 'textarea')
);

$languages = Language::getList();
foreach ($languages as $id => $language)
{
    if (Yii::app()->language == $id)
    {
        continue;
    }

    $value = null;
    if (isset($translations) && isset($translations[$id]))
    {
        $this->model->translations[$id] = $translations[$id];
    }

    $elements["translations[{$id}]"] = array(
        'type'  => 'textarea',
        'label' => $language,
        'value' => $value
    );
}

return array(
    'activeForm' => array(
        'id' => 'language-translation-form'
    ),
    'elements' => $elements,
    'buttons'  => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => 'Сохранить'
        )
    )
);