<?php
/**
 * Обрезает $content используя плагин jTruncate: http://www.jeremymartin.name/projects.php?project=jTruncate
 */
class Truncate extends Portlet
{
    public $content;
    public $options = array();
    private $defaultOptions = array(
        'length'      => 300,
        'minTrail'    => 0,
        'moreText'    => "Подробнее",
        'lessText'    => "",
        'ellipsisText'=> "...",
        'moreAni'     => "fast",
        'lessAni'     => 2000
    );

    public function init()
    {
        parent::init();

        $this->initVars();
        $this->registerScripts();
    }

    public function initVars()
    {
        $this->options = CMap::mergeArray($this->defaultOptions, $this->options);
    }

    public function registerScripts()
    {
        $plugins = $this->assets.'/js/plugins/';

        $options = CJavaScript::encode($this->options);
        Yii::app()->clientScript
            ->registerScriptFile($plugins.'jTruncate/jTruncate.js')
            ->registerScript($this->id.'_truncate', "
                $('#{$this->id}').jTruncate({$options});
            ");
    }

    public function renderContent()
    {
        echo CHtml::tag('div', array('id' => $this->id), $this->content);
    }

    public function getModuleId()
    {
        return 'content';
    }

}