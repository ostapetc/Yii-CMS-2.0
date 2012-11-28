<?

return [
    'activeForm' => [
        'id' => 'sidebar-form',
    ],
    'elements' => [
        'title'        => ['type' => 'text'],
        'html'         => ['type' => 'editor'],
        'is_published' => ['type' => 'checkbox'],
    ],
    'buttons' => [
        'submit' => [
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'создать' : 'сохранить'
        ]
    ]
];


