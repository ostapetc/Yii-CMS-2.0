<?php
Yii::import('zii.widgets.jui.CJuiWidget');
abstract class JuiWidget extends CJuiWidget
{
    public function init()
    {
        $this->attachBehaviors($this->behaviors());
        parent::init();
    }

    public function behaviors()
    {
        return array(
            'CoomponentInModule' => array(
                'class' => 'application.components.behaviors.ComponentInModuleBehavior'
            )
        );
    }


}