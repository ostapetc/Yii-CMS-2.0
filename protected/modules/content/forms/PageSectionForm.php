<?

return [
    'activeForm' => [
        'id'                   => 'pageSection-form',
        'clientOptions'        => [
            'validateOnSubmit'=> true
        ],
    ],
    'elements'  => [
        'name' => [
            'type' => 'text',
        ],
        'parent_id' => [
            'type'  => 'dropdownlist',
            'items' => CHtml::listData(PageSection::model()->findAll(($this->model->isNewRecord ? '' : 'id != ' . $this->model->id)), 'id', 'name'),
            'empty' => 'не выбран'
        ]
    ],
    'buttons'   => [
        'submit' => [
            'type'  => 'submit',
            'value' => 'сохранить'
        ]
    ]
];

