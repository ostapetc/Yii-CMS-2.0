<?php
Yii::import('zii.widgets.jui.CJuiInputWidget');
abstract class JuiInputWidget extends CJuiInputWidget
{
    public $name;
    public $class; //this field use in _form layout

    public $form_id;

    protected $_id;

    public $input_element;


    public function init()
    {
        list($this->name, $this->_id) = $this->resolveNameID();
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


    /**
     * Возвращает id виджета, созданный функцией CJuiInputWidget::reloveNameId()
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }


    /**
     * Обязательный метод для $parent {@link CFormElement}
     *
     * @return CModel
     */
    public function getModel()
    {
        return $this->model;
    }


    public function renderDialog($view, $params = array(), $return = false)
    {
        $options = array(
            'autoOpen'=> true,
            'width'   => 'auto',
            'height'  => 'auto',
            'modal'   => true,
            'title'   => 'Открыть',
        );

        if (isset($params['dialogOptions']))
        {
            $options = CMap::mergeArray($options, $params['dialogOptions']);
            unset($params['dialogOptions']);
        }
        $js_options = CJavaScript::encode($options);

        // the link that may open the dialog
        echo CHtml::link($options['title'], '#', array(
            'onclick'=> "
            $('#{$this->id}').dialog({$js_options}).bind('dialogclose',function(event) {
                $(this).dialog('destroy').appendTo('#{$this->form_id}').hide();
            });
            return false;
        ",
        ));

        return $this->render($view, $params, $return);
    }

}