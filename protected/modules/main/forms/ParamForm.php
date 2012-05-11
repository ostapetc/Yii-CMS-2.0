<?

Yii::app()->clientScript->registerScript(
    'Param-form',
    '
    var oprions_element = $("#Param_options").parents("dl:eq(0)");

    if ($("#Param_element").val() != "select") {
        oprions_element.hide();
    }

    $("#Param_element").change(function() {
        if ($(this).val() == "select") {
            oprions_element.show();
        }
        else {
            oprions_element.hide();
        }
    });
    ',
    CClientScript::POS_READY
);

if ($this->model->scenario == Param::SCENARIO_VALUE_UPDATE)
{
    $elements = array(
        'name'  => array(
            'type'     => 'text',
            'disabled' => true
        )
    );

    if ($this->model->element == Param::ELEMENT_SELECT)
    {
        $items = array();
        foreach (explode("\n", $this->model->options) as $option)
        {
            list($name, $value) = explode(Param::OPTION_NAME_VALUE_SEPARATOR, $option);
            $items[trim($name)] = trim($value);
        }

        $elements['value']  = array(
            'type'  => 'dropdownlist',
            'items' => $items
        );
    }
    else
    {
        $elements['value']  = array(
            'type' => $this->model->element
        );
    }
}
else
{
    $elements = array(
        'module_id' => array(
            'type'  => 'dropdownlist',
            'items' => CHtml::listData(AppManager::getModulesData(), 'dir', 'name'),
        ),
        'name' => array(
            'type' => 'text'
        ),
        'code' => array(
            'type' => 'text'
        ),
        'element' => array(
            'type'  => 'dropdownlist',
            'items' => Param::$elements,
        ),
        'options' => array(
            'type'  => 'textarea',
            'label' => 'Список значений (Каждое название' . Param::OPTION_NAME_VALUE_SEPARATOR . 'значение на новой строке)'
        )
    );
}

return array(
    'enctype'    => 'multipart/form-data',
    'activeForm' => array(
        'id' => 'Param-form',
    ),
    'elements' => $elements,
    'buttons'    => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => 'Сохранить'
        )
    )
);