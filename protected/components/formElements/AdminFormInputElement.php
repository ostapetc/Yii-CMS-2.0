<?php
class AdminFormInputElement extends CFormInputElement
{
    public static $widgets = array(
        'alias'             => 'AliasField',
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


    public $widgets_path = 'application.components.formElements';


    public function renderInput()
    {
        //set default settings
        $this->attributes = CMap::mergeArray($this->defaultWidgetSettings, $this->attributes);

        //replace sinonym on full alias
        if (isset(self::$widgets[$this->type]))
        {
            $this->attributes['form_id']       = $this->getParent()->activeFormWidget->id;
            $this->type                        = self::$widgets[$this->type];
            if (strpos($this->type, '.') === false)
            {
                $this->type = $this->widgets_path . str_repeat('.' . $this->type, 2);
            }
            $attributes=$this->attributes;
            $attributes['model']=$this->getParent()->getModel();
            $attributes['attribute']=$this->name;
            $attributes['input_element']=$this;
            ob_start();
            $this->getParent()->getOwner()->widget($this->type, $attributes);
            return ob_get_clean();
        }

        return parent::renderInput();
    }


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
