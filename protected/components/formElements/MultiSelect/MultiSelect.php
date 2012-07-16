<?php
/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 26.06.12
 * Time: 0:09
 * To change this template use File | Settings | File Templates.
 */

Yii::import('zii.widgets.jui.CJuiInputWidget');

class MultiSelect extends CJuiInputWidget
{
    public function run()
    {
        return CHtml::dropDownList('name', null, array());
    }
}
