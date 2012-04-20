<?
abstract class BaseFormInputElement extends CFormInputElement
{
    public $layout="{hint}\n{label}\n{input}\n{error}";

    public $widgets = array();

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


    abstract public function getDefaultWidgetSettings();

}