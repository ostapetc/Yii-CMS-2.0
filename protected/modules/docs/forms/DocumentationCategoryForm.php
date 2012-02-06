<?php
$elements = array(
    'title'                 => array('type' => 'text'),
    'alias'                 => array(
        'type'   => 'alias',
        'source' => 'title',
        'hint'   => 'Этот параметр будет использован для построения красивого URL. Он генерируется на основании названия, однако до сохранения его можно изменить. После сохранения изменить значение этого поля будет невозможно.'
    ),
    'is_published'          => array('type' => 'checkbox'),
);
if ($this->model->is_system)
{
    unset($elements['alias']);
}
return array(
    'activeForm' => array(
        'id'                     => 'category-form',
        'class'                  => 'CActiveForm',
        'enableAjaxValidation'   => true,
        'htmlOptions'            => array('enctype'=> 'multipart/form-data'),
    ),
    'elements'   => $elements,
    'buttons'    => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => Yii::t('main', 'Отправить'),
        )
    )
);
