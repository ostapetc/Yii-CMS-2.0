<?

$type = $this->model->element;

return array(
    'enctype'    => 'multipart/form-data',
    'activeForm' => array(
        'id'                   => 'setting-form',
        'enableAjaxValidation' => true,
    ),
    'elements'   => array(
        'name'  => array('type' => 'text'),
        'value' => array('type' => $type)
    ),
    'buttons'    => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => 'Сохранить'
        )
    )
);