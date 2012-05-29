<?

Yii::app()->clientScript->registerScriptFile('/js/content/page/form.js');

return array(
    'enctype'    => 'multipart/form-data',
    'activeForm' => array(
        'id'            => 'page-form',
        'clientOptions' => array('validateOnSubmit' => false, 'validateOnType' => false),
        'enableAjaxValidation' => false
    ),
    'elements' => array(
        'title'    => array(
            'type' => 'text'
        ),
//        'url' => array(
//            'type'   => 'alias',
//            'source' => 'title'
//        ),
        'status' => array(
            'type'  => 'dropdownlist',
            'items' => Page::$status_options
        ),
        'text' => array(
            'type'      => 'application.extensions.pageCEditor.elRTE',
            'attribute' => 'text'
        ),
        'tags' => array(
            'type'  => 'TagsInput',
            'label' => 'Теги'
        ),
    ),
    'buttons'              => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => t('сохранить')
        )
    )
);
