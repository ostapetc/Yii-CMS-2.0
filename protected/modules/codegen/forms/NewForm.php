<?php

return array(
    'activeForm'=>array(
        'id' => 'form-form',
    ),
    'elements' => array(
        'model' => array(
            'type'  => 'dropdownlist',
            'items' => AppManager::getModels()
        ),
    ),
    'buttons' => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => t('Создать')
        )
    )
);

