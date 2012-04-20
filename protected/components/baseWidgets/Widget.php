<?
Yii::import('system.web.widgets.CWidget');

abstract class Widget extends CWidget
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
