<?

Yii::app()->clientScript->registerScript(
    'model->form',
    '
    $("#model-form input[name=preview]").click(function() {
        updateCode();
    });

    function updateCode() {
        var data = $("#model-form").serialize();
        $.post("/codegen/modelAdmin/codePreview", data, function(html) {
            $("#code_place").html(html);
        });
    }
    ',
    CClientScript::POS_READY
);

return array(
    'activeForm'=>array(
        'id' => 'model-form',
        'class' => 'CActiveForm',
        'enableAjaxValidation' => true,
        'clientOptions'=>array('validateOnSubmit'=>true)
    ),
    'elements' => array(
        'table' => array(
            'type' => 'text'
        ),
        'class' => array(
            'type' => 'text'
        ),
        'name' => array(
            'type' => 'text'
        ),
        'behaviors' => array(
            'type'     => 'dropdownlist',
            'items'    => array_flip(Model::$extra_behaviors),
            'multiple' => true
        )
    ),
    'buttons' => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => t('сохранить')
        ),
        'preview' => array(
            'type'  => 'button',
            'value' => 'Предпросмотр'
        )
    )
);

