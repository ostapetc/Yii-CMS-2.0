<?
Yii::app()->clientScript->registerScriptFile(Yii::app()->getModule('content')->assetsUrl() . '/js/MenuSectionForm.js');

$menu = Menu::model()->findByPk($this->model->menu_id);

$elements = [
    'page_id' => [
        'type'  => 'dropdownlist',
        'items' => CHtml::listData(Page::model()->language($menu->language)->findAll(), 'id', 'title'),
        'empty' => 'Отсутствует',
        'label' => 'На какую страницу ведет пункт меню',
    ],
    'title'        => ['type' => 'text'],
    'url'          => ['type' => 'text'],
    'is_published' => ['type' => 'checkbox'],
];

return [
    'activeForm' => [
        'id' => 'menu-link-form'
    ],
    'elements'   => $elements,
    'buttons'    => [
        'submit' => [
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'Добавить' : 'Сохранить'
        ]
    ]
];
