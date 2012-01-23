<?php
Yii::import('zii.widgets.jui.CJuiInputWidget');
abstract class InputWidget extends CInputWidget
{
    public $name;
    public $class; //this field use in _form layout
    public $type = 'text';

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
            'CoomponentInModule' => array(
                'class' => 'application.components.behaviors.ComponentInModuleBehavior'
            )
        );
    }

    /**
     * Возвращает id виджета, созданный функцией CInputWidget::reloveNameId()
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Обязательный метод для $parent {@link CFormElement}, почему его нет Yii я не понял, спрошу у авторов
     * @return CModel
     */
    public function getModel()
    {
        return $this->model;
    }

    public function run()
    {
        if (in_array($this->type, FormInputElement::$coreTypes))
        {
            $el = new FormInputElement(array(
                'type' => $this->type,
                'name' => $this->attribute
            ), $this);

            echo $el->renderInput();
        }
        else
        {
            // TODO: тут можно дополнительные типы определить, или какой-то общий алгоритм
        }

    }
}