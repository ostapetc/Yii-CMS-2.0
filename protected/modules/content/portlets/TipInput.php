<?php
/**
 * text или textarea с заранее заданными значениями, например "Ваше Имя"
 * когда поле оказывается в фокусе, поле очищается,
 * когда фокус с поля уходит и оно пусто, значение стандартное возвращается
 */
class TipInput extends InputWidget
{
    public function init()
    {
        parent::init();

        $this->registerScripts();
    }

    public function registerScripts()
    {
        Yii::app()->clientScript
            ->registerScriptFile($this->assets.'/js/plugins/TipInput/tipinput.js')
            ->registerScript($this->id.'_tipInput', "
                $('#{$this->id}').tipInput();
            ");
    }

}