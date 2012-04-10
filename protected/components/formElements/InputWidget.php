<?
Yii::import('zii.widgets.jui.CJuiInputWidget');
abstract class InputWidget extends CInputWidget
{
    public $name;
    public $class; //this field use in _form layout
    public $type = 'text';

    public $form_id;

    public $input_element;


    public function init()
    {
        list($this->name, $this->id) = $this->resolveNameID(); //не стал делать сеттер, если хочешь допиши
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