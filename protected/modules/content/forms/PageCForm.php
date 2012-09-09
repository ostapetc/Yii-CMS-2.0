<?

Yii::app()->clientScript->registerScriptFile('/js/content/page/form.js');

if (!$this->model->isNewRecord)
{
    $this->model->sections_ids = PageSectionRel::model()->getSectionsIds($this->model->id);
    $this->model->sports_ids   = SportRel::model()->getSportsIds($this->model);
}

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
        'status' => array(
            'type'  => 'dropdownlist',
            'items' => Page::$status_options
        ),
        'sports_ids' => array(
            'type'        => 'application.components.formElements.Chosen.Chosen',
            'options'     => CHtml::listData(Sport::model()->findAll(), 'id', 'name'),
            'htmlOptions' => array(
                'multiple'    => true,
                'placeholder' => 'Кликните чтобы выбрать (автодополнение)'
            )
        ),
        'sections_ids' => array(
            'type'        => 'application.components.formElements.Chosen.Chosen',
            'options'     => CHtml::listData(PageSection::model()->findAll(), 'id', 'name'),
            'htmlOptions' => array(
                'multiple'    => true,
                'placeholder' => 'Кликните чтобы выбрать (автодополнение)'
            )
        ),
        'tags' => array(
            'type'  => 'application.components.formElements.Chosen.Chosen',
            'options'     => CHtml::listData(Tag::model()->findAll(), 'id', 'name'),
            'htmlOptions' => array(
                'multiple'    => true,
                'placeholder' => 'Кликните чтобы выбрать (автодополнение)'
            )
        ),
        'text' => array(
            'type'      => 'application.extensions.pageCEditor.elRTE',
            'attribute' => 'text'
        ),
    ),
    'buttons'              => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => t('сохранить')
        )
    )
);
