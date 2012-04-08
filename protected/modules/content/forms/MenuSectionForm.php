<?
Yii::app()->clientScript->registerScriptFile(Yii::app()->getModule('content')->assetsUrl() . '/js/MenuSectionForm.js');

$menu = Menu::model()->findByPk($this->model->menu_id);

$elements = array(
    'page_id' => array(
        'type'  => 'dropdownlist',
        'items' => CHtml::listData(Page::model()->language($menu->language)->findAll(), 'id', 'title'),
        'empty' => 'Отсутствует',
        'label' => 'На какую страницу ведет пункт меню',
    ),
    'title'        => array('type' => 'text'),
    'url'          => array('type' => 'text'),
    'is_published' => array('type' => 'checkbox'),
);

return array(
    'activeForm' => array(
        'id' => 'menu-link-form'
    ),
    'elements'   => $elements,
    'buttons'    => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'Добавить' : 'Сохранить'
        )
    )
);
