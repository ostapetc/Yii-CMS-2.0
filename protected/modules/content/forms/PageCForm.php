<?

Yii::app()->clientScript->registerScriptFile('/js/content/page/form.js');


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
