<?php
class DateColumn extends CDataColumn
{
    public $uiDateFormat = 'd.m.yy';
    public $attribute;


    public function init()
    {
        parent::init();
        $this->uiDateFormat = $this->uiDateFormat ? $this->uiDateFormat : "yy-mm-dd";
        $attr               = $this->attribute = $this->attribute ? $this->attribute : $this->name;

        $start        = '_' . $attr . '_start';
        $end          = '_' . $attr . '_end';
        $_GET[$start] = isset($_GET[$start]) ? $_GET[$start] : 'От';
        $_GET[$end]   = isset($_GET[$end]) ? $_GET[$end] : 'До';

        $this->filter = Yii::app()->controller->widget('ext.jui.FJuiDatePicker', array(
            'name'     => $start,
            'value'    => $_GET[$start],
            'language' => 'ru',
            'options'  => array(
                'dateFormat'=> $this->uiDateFormat
            ),
            'range'    => $attr . '_diapason'
        ), true);
        $this->filter .= Yii::app()->controller->widget('ext.jui.FJuiDatePicker', array(
            'name'     => $end,
            'value'    => $_GET[$end],
            'language' => 'ru',
            'options'  => array(
                'dateFormat'=> $this->uiDateFormat
            ),
            'range'    => $attr . '_diapason'
        ), true);
    }
}