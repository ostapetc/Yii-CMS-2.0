<?

//Yii::app()->clientScript->registerScript(
//    'model->form',
//    '
//    $("#model-form input[name=preview]").click(function() {
//        updateCode();
//    });
//
//    function updateCode() {
//        var data = $("#model-form").serialize();
//        $.post("/codegen/modelAdmin/getCode", data, function(html) {
//            $("#code_place").html(html);
//        });
//    }
//    ',
//    CClientScript::POS_READY
//);

return array(
    'activeForm'=>array(
        'id' => 'model-form',
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
        'module' => array(
            'type'  => 'dropdownlist',
            'items' => CHtml::listData(AppManager::getModulesData(), 'dir', 'name'),
            'empty' => 'не выбран'
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
            'value' => t('Создать')
        ),
        'preview' => array(
            'type'  => 'button',
            'value' => 'Предпросмотр'
        )
    )
);

