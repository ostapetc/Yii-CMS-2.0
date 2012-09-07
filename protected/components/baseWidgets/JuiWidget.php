<?
Yii::import('zii.widgets.jui.CJuiWidget');
abstract class JuiWidget extends CJuiWidget
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