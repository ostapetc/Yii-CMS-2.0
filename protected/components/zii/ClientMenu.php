<?
Yii::import('zii.widgets.CMenu');
class ClientMenu extends TbMenu
{
    public function init()
    {
        $this->attachBehaviors($this->behaviors());
        parent::init();
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