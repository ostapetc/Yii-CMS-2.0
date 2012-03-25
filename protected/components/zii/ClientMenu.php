<?
Yii::import('zii.widgets.CMenu');
class ClientMenu extends CMenu
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