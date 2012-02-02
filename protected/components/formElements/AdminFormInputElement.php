<?php
class AdminFormInputElement extends BaseFormInputElement
{
    public $widgets = array(
        'alias'             => 'AliasField',
        'captcha'           => 'Captcha',
        'chosen'            => 'Chosen',
        'all_in_one_input'  => 'AllInOneInput',
        'multi_select'      => 'EMultiSelect',
        'date'              => 'FJuiDatePicker',
        'checkbox'          => 'IphoneCheckbox',
        'multi_autocomplete'=> 'MultiAutocomplete',
        'editor'            => 'TinyMCE',
        'autocomplete'      => 'zii.widgets.jui.CAutoComplete',
        'meta_tags'         => 'main.portlets.MetaTags',
        'file_manager'      => 'fileManager.portlets.Uploader',
    );


    public function getDefaultWidgetSettings()
    {
        switch ($this->type)
        {
            case 'file_manager':
                $id    = isset($this->id) ? $this->id : 'uploader' . $this->attributes['tag'];
                $title = isset($this->attributes['title']) ? $this->attributes['title'] : 'Файлы';
                return array(
                    'name'        => $this->attributes['tag'],
                    'id'          => $id,
                    'title'       => $title
                );
            case 'alias':
                return array('class' => 'text');
            case 'date':
                return array(
                    'options'    => array(
                        'dateFormat'=> 'd.m.yy'
                    ),
                    'language'   => 'ru',
                    'htmlOptions'=> array('class'=> 'date text date_picker')
                );
            case 'autocomplete':
                return array(
                    'minChars'   => 2,
                    'delay'      => 500,
                    'matchCase'  => false,
                    'htmlOptions'=> array(
                        'size'  => '40',
                        'class' => 'text'
                    )
                );
            case 'dropdownlist':
                return array(
                    'class'=> 'dropdownlist cmf-skinned-select'
                );
            case 'password':
                return array(
                    'class'=> 'dropdownlist text'
                );
            default:
                return array(
                    'class' => $this->type
                );
        }
    }
}
