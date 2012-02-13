<?php
$active_form        = $form->getActiveFormWidget();
$only_on_new_record = array('alias');
if (!$form->model->isNewRecord && in_array($element->type, $only_on_new_record))
{
    return '';
}

$no_label = array('meta_tags', 'file_manager');
if (!in_array($element->type, $no_label))
{
    echo $element->renderHint();
    echo $element->renderLabel();
}

echo $element->renderInput();
echo $element->renderError();
