<?

Yii::app()->clientScript->registerScript(
    'module-form',
    '
    $("#module-form").after("<div id=\'files_div\'><div>");

    $("#Module_id").keyup(function() {
        $("#files_div").load("/codegen/moduleAdmin/getFiles/id/" + $("#Module_id").val());
    });
    ',
    CClientScript::POS_READY
);

return array(
    'activeForm'=>array(
        'id' => 'module-form',
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
            'value' => t('Создать')
        )
    )
);

