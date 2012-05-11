<?

return array(
    'activeForm' => array(
        'id'                   => 'pageSection-form',
        'clientOptions'        => array(
            'validateOnSubmit'=> true
        ),
    ),
    'elements'  => array(
        'name' => array(
            'type' => 'text',
        ),
        'parent_id' => array(
            'type'  => 'dropdownlist',
            'items' => CHtml::listData(PageSection::model()->findAll(($this->model->isNewRecord ? '' : 'id != ' . $this->model->id)), 'id', 'name'),
            'empty' => 'не выбран'
        )
    ),
    'buttons'   => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => 'сохранить'
        )
    )
);

