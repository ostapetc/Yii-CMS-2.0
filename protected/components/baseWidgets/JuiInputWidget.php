<?php
abstract class JuiInputWidget extends CJuiInputWidget
{
    public $name;
    public $class; //this field use in _form layout

    protected $_id;

    public function init()
    {
        list($this->name, $this->_id) = $this->resolveNameID();
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
     * Возвращает id виджета, созданный функцией CJuiInputWidget::reloveNameId()
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Обязательный метод для $parent {@link CFormElement}
     * @return CModel
     */
    public function getModel()
    {
        return $this->model;
    }
}