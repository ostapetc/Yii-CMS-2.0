<?php
class SortableBehavior extends CBehavior
{
    public $sortableOptions=array();
    public $saveUrl;

    public function attach($owner)
    {
        parent::attach($owner);
        $id = $owner->id;

        $this->sortableOptions['update'] = "js:function(event, ui)
        {
        alert(jQuery('#{$id} ul').sortable('serialize'));
            $.post('{$this->saveUrl}', jQuery('#{$id} ul').sortable('serialize'));
        }";
        $jsOptions=empty($this->sortableOptions) ? '' : CJavaScript::encode($this->sortableOptions);
        Yii::app()->getClientScript()
            ->registerCoreScript('jquery.ui')
            ->registerScript(__CLASS__.'#'.$id,"jQuery('#{$id} ul').sortable({$jsOptions});");
    }
}