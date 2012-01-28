<?php
Yii::import('zii.widgets.jui.CJuiInputWidget');
abstract class InputWidget extends CInputWidget
{
    public $name;
    public $class; //this field use in _form layout
    public $type = 'text';

    public $form_id;

    public $input_element;


    protected $_id;

    public function init()
    {
        list($this->name, $this->_id) = $this->resolveNameID(); //не стал делать сеттер, если хочешь допиши
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
     * Возвращает id виджета, созданный функцией CInputWidget::reloveNameId()
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }


    /**
     * Обязательный метод для $parent {@link CFormElement}, почему его нет Yii я не понял, спрошу у авторов
     *
     * @return CModel
     */
    public function getModel()
    {
        return $this->model;
    }


    public function run()
    {
    }
}