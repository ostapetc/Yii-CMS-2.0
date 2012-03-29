<?

Yii::app()->clientScript->registerScript(
    'module-form',
    '
    $("#module-form").after("<div id=\'files_div\'><div>");

    $("#Module_id").keydown(function() {
        $("#files_div").load("/codegen/moduleAdmin/showFiles/id/" + $("#Module_id").val());
    });
    ',
    CClientScript::POS_READY
);

return array(
    'activeForm'=>array(
        'id' => 'module-form',
        'class' => 'CActiveForm',
        'enableAjaxValidation' => true,
        'clientOptions'=>array('validateOnSubmit'=>true)
    ),
    'elements' => array(
        'id' => array(
            'type' => 'text'
        ),
        'name' => array(
            'type' => 'text'
        ),
        'description' => array(
            'type' => 'text'
        ),
    ),
    'buttons' => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => t('сохранить')
        )
    )
);

