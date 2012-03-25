<?
Yii::import('zii.widgets.jui.CJuiInputWidget');
abstract class JuiInputWidget extends CJuiInputWidget
{
    public $name;
    public $class; //this field use in _form layout

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

        $linkOptions = array(
            'onclick'=> "
                $('#{$this->id}').dialog({$js_options}).bind('dialogclose',function(event) {
                    $(this).dialog('destroy').appendTo('#{$this->form_id}').hide();
                });
                return false;
            ",
        );
        if (isset($params['linkOptions']))
        {
            $linkOptions = CMap::mergeArray($linkOptions, $params['linkOptions']);
            unset($params['linkOptions']);
        }

        // the link that may open the dialog
        echo CHtml::link($options['title'], '#', $linkOptions);

        return $this->render($view, $params, $return);
    }

}