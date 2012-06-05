<?
class FormInputElement extends CFormInputElement
{
    public $layout = "{hint}\n{label}\n{input}\n{error}";


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
        'elrteEditor'       => 'application.extensions.elrte.elRTE',
        'markdown'          => 'EMarkitupWidget',
        'autocomplete'      => 'zii.widgets.jui.CAutoComplete',
        'meta_tags'         => 'main.portlets.MetaTags',
        'file_manager'      => 'fileManager.portlets.Uploader',
    );

    public $widgets_path = 'application.components.formElements';


    public function renderInput()
    {
        //set default settings
        $this->attributes = CMap::mergeArray($this->defaultWidgetSettings, $this->attributes);

        /*
         * if we have more than 1 forms on page for single model,
         * than at some input will be same id. we must set different id.
         * but Yii generate non different id for error tag.
         */

        if (!isset($this->errorOptions['inputID']) && isset($this->attributes['id']))
        {
            $this->errorOptions['inputID'] = $this->attributes['id'];
        }

        //replace sinonym on full alias
        if (isset($this->widgets[$this->type]))
        {
            $this->attributes['form_id'] = $this->getParent()->activeFormWidget->id;
            $this->type                  = $this->widgets[$this->type];
            if (strpos($this->type, '.') === false)
            {
                $this->type = $this->widgets_path . str_repeat('.' . $this->type, 2);
            }

            $attributes                  = $this->attributes;
            $attributes['model']         = $this->getParent()->getModel();
            $attributes['attribute']     = $this->name;
            $attributes['input_element'] = $this;
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
                $id    = isset($this->attributes['id']) ? $this->attributes['id'] : 'uploader' . $this->name;
                $title = isset($this->attributes['title']) ? $this->attributes['title'] : 'Файлы';

                return array(
                    'id'          => $id,
                    'title'       => $title
                );

            case 'date':
                return array(
                    'options'       => array(
                        'dateFormat'=> 'd.m.yy'
                    ),
                    'language'      => 'ru',
                    'htmlOptions'   => array('class'=> 'date text date_picker')
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
                    'class' => 'dropdownlist cmf-skinned-select'
                );

            case 'markdown':
                return array(
                    'htmlOptions'=> array(
                        'settings' => 'markdown'
                    )
                );

            default:
                return array();
        }
    }


    public function renderLabel()
    {
        if (in_array($this->type, array(
            'meta_tags',
            'file_manager'
        ))
        )
        {
            return '';
        }

        return parent::renderLabel();
    }
}