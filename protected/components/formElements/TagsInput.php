<?

class TagsInput extends InputWidget
{
    public function run()
    {
        $this->registerScripts();
        echo CHtml::textField('tags');
    }


    public function registerScripts()
    {
        $assets = $this->assets;
    }
}
