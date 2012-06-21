<?
class FormButtonElement extends CFormButtonElement
{
    public function render()
    {
        $method = $this->type;
        if (strpos($this->type, 'ajax') === 0)
        {
            if (!isset($this->attributes['value']))
            {
                throw new CException('Ajax кнопки должны иметь параметр value');
            }
            if (!isset($this->attributes['url']))
            {
                throw new CException('Ajax кнопки должны иметь параметр url');
            }
            $htmlOptions = isset($this->attributes['htmlOptions']) ? $this->attributes['htmlOptions'] : array();
            $ajaxOptions = isset($this->attributes['ajaxOptions']) ? $this->attributes['ajaxOptions'] : array();
            return CHtml::$method($this->attributes['value'], $this->attributes['url'], $ajaxOptions, $htmlOptions);
        }
        else
        {
            return parent::render();
        }
    }
}