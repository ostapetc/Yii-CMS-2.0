<?
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

        //variables
        $start        = '_' . $attr . '_start';
        $end          = '_' . $attr . '_end';
        $_GET[$start] = isset($_GET[$start]) ? $_GET[$start] : '';
        $_GET[$end]   = isset($_GET[$end]) ? $_GET[$end] : '';

        //settings
        $widget         = 'application.components.formElements.FJuiDatePicker.FJuiDatePicker';
        $settings       = array(
            'language'   => 'ru',
            'options'    => array(
                'dateFormat'=> $this->uiDateFormat
            ),
            'htmlOptions'=> array(
                'style' => 'width:100px;'
            ),
            'range'      => $attr . '_diapason'
        );
        $label_styles   = array('style'=> 'float:left; vertical-align: top;margin-right:3px');
        $wrapper_styles = array(
            'class'=> 'small',
            'style'=> 'min-width: 150px;'
        );

        //first input
        $res = CHtml::tag('span', $label_styles, t('От:'));
        $res .= Yii::app()->controller->widget($widget, CMap::mergeArray($settings, array(
            'name'     => $start,
            'value'    => $_GET[$start],
        )), true);

        echo CHtml::tag('div', $wrapper_styles, $res);

        //second input
        $res = CHtml::tag('span', $label_styles, t('До:'));
        $res .= Yii::app()->controller->widget($widget, CMap::mergeArray($settings, array(
            'name'     => $end,
            'value'    => $_GET[$end],
        )), true);

        echo CHtml::tag('div', $wrapper_styles, $res);
    }
}