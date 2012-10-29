<?

Yii::app()->clientScript->registerScriptFile('/js/content/page/form.js');

if (!$this->model->isNewRecord)
{
    $this->model->sections_ids = PageSectionRel::model()->getSectionsIds($this->model->id);
    $this->model->sports_ids   = SportRel::model()->getSportsIds($this->model);
}

return [
    'enctype'    => 'multipart/form-data',
    'activeForm' => [
        'id'            => 'page-form',
        'clientOptions' => ['validateOnSubmit' => false, 'validateOnType' => false],
        'enableAjaxValidation' => false
    ],
    'elements' => [
        'title'    => [
            'type' => 'text'
        ],
        'status' => [
            'type'  => 'dropdownlist',
            'items' => Page::$status_options
        ],
        'sports_ids' => [
            'type'        => 'application.components.formElements.Chosen.Chosen',
            'options'     => CHtml::listData(Sport::model()->findAll(), 'id', 'name'),
            'htmlOptions' => [
                'multiple'    => true,
                'placeholder' => 'Кликните чтобы выбрать (автодополнение)'
            ]
        ],
        'sections_ids' => [
            'type'        => 'application.components.formElements.Chosen.Chosen',
            'options'     => CHtml::listData(PageSection::model()->findAll(), 'id', 'name'),
            'htmlOptions' => [
                'multiple'    => true,
                'placeholder' => 'Кликните чтобы выбрать (автодополнение)'
            ]
        ],
        'tags' => [
            'type'  => 'application.components.formElements.Chosen.Chosen',
            'options'     => CHtml::listData(Tag::model()->findAll(), 'id', 'name'),
            'htmlOptions' => [
                'multiple'    => true,
                'placeholder' => 'Кликните чтобы выбрать (автодополнение)'
            ]
        ],
        'text' => [
            'type'      => 'application.extensions.pageCEditor.elRTE',
            'attribute' => 'text'
        ],
    ],
    'buttons'              => [
        'submit' => [
            'type'  => 'submit',
            'value' => t('сохранить')
        ]
    ]
];
