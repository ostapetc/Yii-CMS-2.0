<?

Yii::app()->clientScript->registerScript(
    'crud-form',
    '
    $("#crud-form").after("<div id=\'files_div\'><div>");

    $("#Crud_model").change(function() {
        var model = $(this).val();

        if (model) {
            $("#files_div").load("/codegen/crudAdmin/getFiles/model/" + model);
        }
        else {
            $("#files_div").html("");
        }
    });
    ',
    CClientScript::POS_READY
);

return array(
    'activeForm'=>array(
        'id'                   => 'crud-form',
        'enableAjaxValidation' => false,
        'clientOptions'        => array('validateOnSubmit' => false)
    ),
    'elements' => array(
        'class' => array(
            'type'  => 'dropdownlist',
            'items' => AppManager::getModels(),
            'empty' => 'не выбрано',
            'label' => 'Модель'
        ),
        'genetive' => array(
            'type'  => 'text',
            'label' => 'Добавление кого?, чего?'
        ),
        'instrumental' => array(
            'type'  => 'text',
            'label' => 'Управление кем?, чем?'
        ),
        'accusative' => array(
            'type'  => 'text',
            'label' => 'Создать кого?, что?'
        ),
    ),
    'buttons' => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => t('Создать')
        )
    )
);

