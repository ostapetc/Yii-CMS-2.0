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
        'id' => 'crud-form',
        'enableAjaxValidation' => true,
        'clientOptions'=>array('validateOnSubmit'=>true)
    ),
    'elements' => array(
        'model' => array(
            'type'  => 'dropdownlist',
            'items' => AppManager::getModels(),
            'empty' => 'не выбрано'
        ),
    ),
    'buttons' => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => t('Создать')
        )
    )
);

