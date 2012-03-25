<?
class MaskedTextField extends CMaskedTextField
{
    public $type;
    public $masks = array(
        'phone' => "+9(999)999-99-99"
    );

    public function init()
    {
        $this->mask = $this->masks[$this->type];
        parent::init();
    }
}