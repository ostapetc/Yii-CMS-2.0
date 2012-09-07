<?
Yii::import('zii.widgets.CPortlet');

/**
 * @property string $assets
 */
class Portlet extends CPortlet
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


    public function createUrl($url, $params = array())
    {
        return Yii::app()->controller->createUrl($url, $params);
    }
}
