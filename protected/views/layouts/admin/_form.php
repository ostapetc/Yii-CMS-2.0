<?php
$active_form        = $form->getActiveFormWidget();
if (Yii::app()->params['multilanguage_support'] == false)
{
    if ($element->name == 'lang')
    {
        return '';
    }
}

$no_label = array('meta_tags', 'file_manager');
if (!in_array($element->type, $no_label))
{
    echo $element->renderHint();
    echo $element->renderLabel();
}

echo $element->renderInput();
echo $element->renderError();
