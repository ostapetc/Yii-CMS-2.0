<?php
$active_form        = $form->getActiveFormWidget();
$only_on_new_record = array('alias');
if (!$form->model->isNewRecord && in_array($element->type, $only_on_new_record))
{
    return '';
}

$no_label = array('MetaTags', 'file_manager');
if (!in_array($element->type, $no_label))
{
    echo $element->renderHint();
    echo $active_form->labelEx($form->model, $element->name);
}

//widgets
switch ($element->type)
{
    case 'file_manager':
        $id    = isset($element->id) ? $element->id : 'uploader' . $element->attributes['tag'];
        $title = isset($element->attributes['title']) ? $element->attributes['title'] : 'Файлы';
        Yii::app()->clientScript->registerScript("{$id}_checker", '
            $("#' . $id . '_checker").click(function(){$(this).siblings(".uploader").slideToggle(); return false;});
        ');
        echo CHtml::link($title, "#", array(
            'id'    => $id . '_checker',
            'class' => 'fieldset-checker'
        ));
        $this->widget('fileManager.portlets.Uploader', array(
            'model'       => $form->model,
            'id'          => $id,
            'data_type'   => $element->attributes['data_type'],
            'maxFileSize' => 10 * 1000 * 1000,
            'tag'         => $element->attributes['tag'],
            'title'       => $title
        ));
        break;
    case 'chosen':
        $this->type  = 'dropdownlist';
        $this->class = 'chosen';
        break;
    case 'multi_select':
        echo $this->getParent()->getActiveFormWidget()
            ->dropdownlist($this->model, $this->name, $this->items, array(
            'multiple' => 'multiple',
            'key'      => isset($this->key) ? $this->key : 'id',
            'class'    => 'multiselect'
        ));
        break;
    default:
        echo $element->renderInput();
        break;
}

echo $active_form->error($form->model, $element->name);
?>


