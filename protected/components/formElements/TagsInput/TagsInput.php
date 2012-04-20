<?

class TagsInput extends InputWidget
{
    private $element_name = 'tags';
    private $default_text = 'Введите тэги';


    public function run()
    {
        $model_class = get_class($this->model);

        $this->registerScripts($model_class);
        echo CHtml::textField("{$model_class}[{$this->element_name}]", '', array('id' => $model_class . '_' . $this->element_name, 'class' => 'text'));
    }


    public function registerScripts($model_class)
    {
        Yii::app()->getClientScript()
                  ->registerScriptFile($this->assets . '/jquery.tagsinput.min.js')
                  ->registerCssFile($this->assets . '/jquery.tagsinput.css')
                  ->registerScript(
                        'da',
                        '$("#' .  $model_class . '_' . $this->element_name . '").tagsInput({
                            "width"       : "420px",
                            "defaultText" : "' . $this->default_text . '"
                        });',
                        CClientScript::POS_READY
                    );
    }

}
