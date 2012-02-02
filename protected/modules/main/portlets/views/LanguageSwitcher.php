<?php
$max_index = count($langs) - 1;
foreach ($langs as $i => $lang)
{
    if ($lang->id == Yii::app()->language)
    {
        echo '<b>' . $lang->name . '</b>';
    }
    else
    {
        echo CHtml::link($lang->name, '/' . $lang->id);
    }
    if ($max_index > $i)
    {
        echo '&nbsp;|&nbsp;';
    }
}
