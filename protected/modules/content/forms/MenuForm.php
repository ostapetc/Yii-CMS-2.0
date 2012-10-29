<?

return [
    'activeForm' => [
        'id'    => 'menu-form',
    ],
    'elements' => [
        'name'         => ['type' => 'text'],
        'code'         => ['type' => 'text'],
        'is_published' => ['type' => 'checkbox']
    ],
    'buttons' => [
        'submit' => ['type' => 'submit', 'value' =>  $this->model->isNewRecord ? 'Далее' : 'Сохранить'],
    ]
];