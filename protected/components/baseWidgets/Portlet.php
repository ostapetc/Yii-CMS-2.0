<?
Yii::import('zii.widgets.CPortlet');

/**
 * @property string $assets
 */
class Portlet extends CPortlet
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


    public function createUrl($url, $params = array())
    {
        return Yii::app()->controller->createUrl($url, $params);
    }
}
