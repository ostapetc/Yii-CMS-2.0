<?php

$elements = array(
    'message' => array('type' => 'textarea')
);

$config = AppManager::getConfig();
p($config);

$languages = Language::getCachedArray();
foreach ($languages as $id => $language)
{
    $elements["translations[{$id}]"] = array(
        'type'  => 'textarea',
        'label' => $language
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