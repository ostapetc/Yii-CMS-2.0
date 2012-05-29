<?
class ClientFormInputElement extends BaseFormInputElement
{
    public $widgets = array(
        'alias'             => 'AliasField',
        'file'              => 'FileWidget',
        'captcha'           => 'Captcha',
        'chosen'            => 'Chosen',
        'all_in_one_input'  => 'AllInOneInput',
        'multi_select'      => 'EMultiSelect',
        'date'              => 'FJuiDatePicker',
        'checkbox'          => 'IphoneCheckbox',
        'multi_autocomplete'=> 'MultiAutocomplete',
        'editor'            => 'TinyMCE',
        'markdown'          => 'EMarkitupWidget',
        'autocomplete'      => 'zii.widgets.jui.CAutoComplete',
        'meta_tags'         => 'main.portlets.MetaTags',
        'file_manager'      => 'fileManager.portlets.Uploader',
    );


    public function getDefaultWidgetSettings()
    {
        switch ($this->type)
        {
            case 'date':
                return array(
                    'options'    => array(
                        'dateFormat'=> 'd.m.yy'
                    ),
                    'language'   => 'ru',
                    'htmlOptions'=> array('class'=> 'date text date_picker')
                );
            default:
                return array();
        }
    }
}
