<?
Yii::import('zii.widgets.jui.CJuiInputWidget');
abstract class JuiInputWidget extends CJuiInputWidget
{
    public $name;


    public $input_element;

    public $themeUrl = '/css/jqueryUiThemes/';
    public $theme = 'bootstrap';
    public $cssFile = 'jquery-ui-1.8.16.custom.css';

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
        Yii::app()->controller->beginWidget('TbModal', array(
            'htmlOptions' => array(
                'id' => 'modal_' . $this->getId(),
                'style' => 'width: auto;',
                'class' => 'hide',
            )
        ));
        $this->render($view, $params);
        Yii::app()->controller->endWidget('TbModal');

        // the link that may open the dialog
        echo CHtml::link($params['title'], '#modal_'.$this->getId(), $linkOptions);

    }

}