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
    echo $active_form->labelEx($form->model, $element->name);
}

//widgets
switch ($element->type)
{
    case 'chosen':
        $this->type  = 'dropdownlist';
        $this->class = 'chosen';
        break;
    default:
        echo $element->renderInput();
        break;
}

echo $active_form->error($form->model, $element->name);
