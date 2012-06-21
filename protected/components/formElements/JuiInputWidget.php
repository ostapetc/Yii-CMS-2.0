<?
Yii::import('zii.widgets.jui.CJuiInputWidget');
abstract class JuiInputWidget extends CJuiInputWidget
{
    public $name;

    public $form_id;

    public $input_element;


    public function init()
    {
        list($this->name, $this->id) = $this->resolveNameID();
        $this->attachBehaviors($this->behaviors());

        parent::init();
    }


    public function behaviors()
    {
        return array(
            'InputWidget' => array(
                'class' => 'application.components.behaviors.InputWidgetBehavior'
            )
        );
    }


    public function renderDialog($view, $params = array(), $return = false)
    {
        $linkOptions = isset($params['linkOptions']) ? $params['linkOptions'] : array();
        $linkOptions['data-toggle'] = 'modal';
        // the link that may open the dialog
        echo CHtml::link($params['title'], '#'.$this->getId(), $linkOptions);
        Yii::app()->controller->beginWidget('BootModal', array(
            'htmlOptions' => array(
                'id' => $this->getId(),
                'style' => 'width: auto;',
                'class' => 'hide',
            )
        ));
        $this->render($view, $params);
        Yii::app()->controller->endWidget('BootModal');
    }

}