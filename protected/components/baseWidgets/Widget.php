<?
Yii::import('system.web.widgets.CWidget');

abstract class Widget extends CWidget
{
    public function __construct()
    {
        $this->attachBehaviors($this->behaviors());
        parent::__construct();
    }


    public function behaviors()
    {
        return array(
            'ComponentInModule' => array(
                'class' => 'application.components.behaviors.ComponentInModuleBehavior'
            )
        );
    }

}
