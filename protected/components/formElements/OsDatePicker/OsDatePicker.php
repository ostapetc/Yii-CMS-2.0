<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artem.ostapetc
 * Date: 26.06.12
 * Time: 10:24
 * To change this template use File | Settings | File Templates.
 */
class OsDatePicker extends JuiInputWidget
{
    //public $attribute;

    public $items = array();

    public $model;


    public function init()
    {
        parent::init();

        if (!$this->model instanceof ActiveRecord)
        {
            throw new CException(t('Needs param model instanceof ActiveRecord!'));
        }

        if (!$this->attribute)
        {
            throw new CException(t('Needs param attribute!'));
        }

        if (!is_array($this->items))
        {
            throw new CException(t('Needs param items typeof Array!'));
        }
    }


    public function run()
    {
        $cs = Yii::app()->clientScript;
        $cs->registerCssFile($this->assets . 'OsDatePicker.css');
        $cs->registerScriptFile($this->assets . 'OsDatePicker.js');

        $name = $this->resolveNameID();
        $name = $name[0];

        $value = explode('-', $this->model{$this->attribute});

        $content = "<div class='os-date-picker'>";

        $content.= CHtml::dropDownList(
            $name . '[day]',
            (int) (isset($value[2]) ? $value[2] : null),
            array_combine(range(1, 31), range(1, 31)),
            array(
                'class' => 'day',
                'empty' => t('День') . ':'
            )
        );

        $content.= CHtml::dropDownList(
            $name . '[month]',
            (int) (isset($value[1]) ? $value[1] : null),
            Yii::app()->locale->monthNames,
            array(
                'class' => 'month',
                'empty' => t('Месяц') . ':'
            )
        );

        $content.= CHtml::textField(
            $name . '[year]',
            isset($value[0]) ? $value[0] : null,
            array(
                'class'       => 'year',
                'empty'       => t('Год') . ':',
                'placeholder' => '. . . .', 'maxlength' => 4
            )
        );

        $content.= CHtml::hiddenField($name, $this->model{$this->attribute}, array('class' => 'date-value'));
        $content.= "</div";

        echo $content;
    }
}
