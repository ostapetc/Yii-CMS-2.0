<?php
$active_form = $form->getActiveFormWidget();
$only_on_new_record = array('alias');
if (!$form->model->isNewRecord && in_array($element->type, $only_on_new_record))
{
    return '';
}

$no_label            = array('MetaTags', 'file_manager');
if (!in_array($element->type, $no_label))
{
    echo $element->renderHint();
    echo $active_form->labelEx($form->model, $element->name);
}

//input widgets
switch ($element->type)
{
    case 'checkbox':
        $element->type = 'main.components.IphoneCheckbox';
        break;
    case 'multi_autocomplete':
        $element->type = 'products.portlets.MultiAutocomplete';
        break;
    case 'alias':
        $element->type  = 'main.components.AliasField';
        $element->class = 'text';
        break;
    case 'chosen':
        $element->type  = 'dropdownlist';
        $element->class = 'chosen';
        break;
    case 'date':
        $element->type = 'ext.jui.FJuiDatePicker';
        $element->attributes['options']  = array('dateFormat'=> 'd.m.yy');
        $element->attributes['language']  = 'ru';
        break;
}

//widgets
switch ($element->type)
{
    case 'editor':
        $this->widget('ext.tiny_mce.TinyMCE', array(
            //                'editorTemplate' => 'full',
            'model'     => $form->model,
            'attribute' => $element->name,
        ));
        break;
    case 'multi_select':
        $this->widget('ext.emultiselect.EMultiSelect', $element->attributes);
        echo $active_form->dropdownlist($form->model, $element->name, $element->items, array(
            'multiple' => 'multiple',
            'key'      => isset($element->key) ? $element->key : 'id',
            'class'    => 'multiselect'
        ));
        break;
    case 'autocomplete':
        $this->widget('CAutoComplete', array(
            'name'       => $element->name,
            'attribute'  => $element->name,
            'model'      => $form->model,
            'url'        => array($element->url),
            'minChars'   => 2,
            'delay'      => 500,
            'matchCase'  => false,
            'htmlOptions'=> array(
                'size'  => '40',
                'class' => 'text'
            )
        ));
        break;
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

    default:
        echo $element->renderInput();
        break;
}

echo $active_form->error($form->model, $element->name);
?>


