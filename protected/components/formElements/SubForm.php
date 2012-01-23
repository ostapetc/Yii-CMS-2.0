<?php
class SubForm extends Portlet
{
    public $tagName = 'fieldset';

    public function init()
    {
        Yii::app()->clientScript->registerScript('SubForm', "
            $('legend').click(function() {
                var legend = $(this);
                legend.siblings('.portlet-content').slideToggle();

                return false;
            });
        ");
        parent::init();
    }

    public function renderDecoration()
    {
        if ($this->title !== null)
        {
            echo "<legend>{$this->title}</legend>";
        }
    }

}