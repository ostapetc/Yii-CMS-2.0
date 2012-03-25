<?
class MultiAutocomplete extends InputWidget
{
    private $defaultOptions = array();
    public $options = array();

    public $selected = array();

    public $type = 'dropdownlist';

    public $url = null;


    /**
     * Apply chosen plugin to select boxes.
     */
    public function run()
    {
        $this->initVars();
        $this->registerScripts();

        echo CHtml::dropDownList($this->name . '[]', $this->model->{$this->selected}, $this->model->{
        $this->attribute . '_source'}, array(
            'id'       => $this->id,
            'multiple' => 'true',
            'encode'   => false
        ));
    }


    public function initVars()
    {
        $this->options = CMap::mergeArray($this->defaultOptions, $this->options);
    }


    public function registerScripts()
    {
        $assets = $this->assets;

        $options = CJavaScript::encode(array(
            'url' => $this->url
        ));

        Yii::app()->getClientScript()->registerScriptFile($assets . '/multi_autocomplete.js')
            ->registerCoreScript('jquery.ui')->registerCssFile(
            Yii::app()->clientScript->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css')->registerCssFile(
            Yii::app()->clientScript->getCoreScriptUrl() . '/jui/css/base/jquery.ui.autocomplete.css')
            ->registerScript($this->id, "$('#{$this->id}').multiAutocomplete({$options});");
    }
}

?>