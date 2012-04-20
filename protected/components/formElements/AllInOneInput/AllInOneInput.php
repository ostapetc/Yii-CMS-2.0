<?
class AllInOneInput extends JuiInputWidget
{
    public function init()
    {
        parent::init();
        $this->registerScripts();
    }

    public function registerScripts()
    {
        $plugins = $this->assets . '/js/plugins/';

        Yii::app()->clientScript->registerScriptFile($plugins . 'allInOneInput.js')->registerCssFile(
            $this->assets . '/css/all_in_one_input.css')
            ->registerScript($this->id, "$('#{$this->id}').allInOneInput();");
    }

    public function run()
    {
        $el = new ClientFormInputElement(array(
            'type' => 'text',
            'name' => $this->attribute,
        ), $this);

        echo $el->renderInput();
    }
}