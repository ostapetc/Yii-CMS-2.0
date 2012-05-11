<?
class NestedSortable extends Portlet
{
    public $model;
    public $sortable = false;
    public $id;
    public $root_id;

    private $defaultSoringSettings = array(
        'listType'            => 'ul',
        'toleranceElement'    => '> div',
        'forcePlaceholderSize'=> true,
        'forceHelperSize'     => true,
        'handle'              => '.drag',
        'disableNesting'      => 'no-nest',
        'helper'              => 'clone',
        'items'               => 'li',
        'maxLevels'           => 0,
        'opacity'             => .6,
        'placeholder'         => 'placeholder',
        'start'=>"js:function(event, ui)
        {
            ui.placeholder.html('<div>&nbsp;</div>');
        }",
        'revert'              => true,
        'tabSize'             => 25,
        'tolerance'           => 'pointer',
    );

    public $sortingSettings = array();


    public function init()
    {
        parent::init();
        $this->initVars();
        $this->registerScripts();
    }


    public function initVars()
    {
        $this->sortingSettings = CMap::mergeArray($this->defaultSoringSettings, $this->sortingSettings);
    }


    public function registerScripts()
    {
        $plugins = $this->assets.'/js/plugins/';
        $cs      = Yii::app()->clientScript;

        if ($this->sortable)
        {
            $settings = CJavaScript::encode($this->sortingSettings);
            $cs->registerScriptFile($plugins.'nestedSortable/nestedSortable.js')
               ->registerCssFile($plugins.'nestedSortable/nestedSortable.css')
               ->registerScriptFile($plugins.'toJson/toJson.js')
               ->registerScript($this->id.'NestedTreeSortable', "$('#{$this->id} > ul').nestedSortable({$settings})");
        }
    }


    public function renderContent()
    {
        $this->render('NestedSortable', array(
            'tree' => $this->model->getHtmlTree($this->root_id)
        ));
    }

}