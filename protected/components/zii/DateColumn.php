<?php
class DateColumn extends CDataColumn
{
    public $uiDateFormat = 'dd.mm.yy';
    public $attribute;

    public function renderFilterCellContent()
    {
        if ($this->filter === false)
        {
            return false;
        }
        $this->uiDateFormat = $this->uiDateFormat ? $this->uiDateFormat : "yy-mm-dd";
        $attr               = $this->attribute = $this->attribute ? $this->attribute : $this->name;

        $start        = '_' . $attr . '_start';
        $end          = '_' . $attr . '_end';
        $_GET[$start] = isset($_GET[$start]) ? $_GET[$start] : '';
        $_GET[$end]   = isset($_GET[$end]) ? $_GET[$end] : '';

        $widget   = 'application.components.formElements.FJuiDatePicker.FJuiDatePicker';
        $settings = array(
            'language'   => 'ru',
            'options'    => array(
                'dateFormat'=> $this->uiDateFormat
            ),
            'htmlOptions'=> array(
                'style' => 'display:inline-block;width:100px;float:right'
            ),
            'range'      => $attr . '_diapason'
        );
        $res      = CHtml::tag('span', array('style'=> 'float:left'), 'От:');
        $res .= Yii::app()->controller->widget($widget, CMap::mergeArray($settings, array(
            'name'     => $start,
            'value'    => $_GET[$start],
        )), true);

        echo CHtml::tag('div', array('style'=> 'min-width: 130px;'), $res);

        $res = CHtml::tag('span', array('style'=> 'float:left'), 'До:');
        $res .= Yii::app()->controller->widget($widget, CMap::mergeArray($settings, array(
            'name'     => $end,
            'value'    => $_GET[$end],
        )), true);

        echo CHtml::tag('div', array('style'=> 'min-width: 130px;'), $res);
    }
}