<?php

class BaseForm extends CForm
{
    private $_clear = false;

    public $side;

    public $cancel_button_show = true;

    public $inputElementClass = null;


    public function __construct($config, $model = null, $parent = null)
    {
        if ($this->side == null)
        {
            $this->side = Yii::app()->controller instanceof AdminController ? 'admin' : 'client';
        }

        if ($this->inputElementClass == null)
        {
            $this->inputElementClass = $this->side . 'FormInputElement';
        }


        if (is_string($config))
        {
            $config = self::getFullAlias($config);
        }

        parent::__construct($config, $model, $parent);

        $this->addAttributesToButtons();
        $this->formatDateAttributes();
    }


    public static function getFullAlias($alias)
    {
        list($module, $form) = explode(".", $alias, 2);
        return "application.modules.{$module}.forms.{$form}";
    }


    public static function getFormConfig($alias)
    {
        if (is_string($alias))
        {
            $alias = self::getFullAlias($alias);
            return require(Yii::getPathOfAlias($alias) . '.php');
        }
        else
        {
            return $alias;
        }
    }


    public function runSideMethod()
    {
        $params         = func_get_args();
        $func_base_name = array_shift($params);

        $function = $func_base_name . ucfirst($this->side);
        if (method_exists($this, $function))
        {
            $params = call_user_func_array(array($this, $function), $params);
        }
    }


    public function __toString()
    {
        $cs = Yii::app()->clientScript;

        if (!($this->parent instanceof self))
        {
            $this->runSideMethod('_registerScripts');

            if ($this->_clear)
            {
                $cs->registerScript('clearForm', '$(function()
                {
                    $(":input","#' . $this->activeForm['id'] . '")
                        .not(":button, :submit, :reset, :hidden")
                        .val("")
                        .removeAttr("checked")
                        .removeAttr("selected");
                })');
            }

            try
            {
                return parent::__toString();
            } catch (Exception $e)
            {
                Yii::app()->handleException($e);
            }
        }
    }


    private function _registerScriptsAdmin()
    {
        Yii::app()->clientScript->registerScriptFile('/js/admin/admin_form.js')
            ->registerScriptFile('/js/admin/admin_form.js')
            ->registerScriptFile('/js/plugins/adminForm/buttonSet.js')
            ->registerScriptFile('/js/plugins/adminForm/tooltips/jquery.atooltip.js')
            ->registerCssFile('/js/plugins/adminForm/tooltips/atooltip.css');
    }


    private function _registerScriptsClient()
    {
        $id = $this->activeForm['id'];
        Yii::app()->clientScript
            ->registerScriptFile('/js/plugins/clientForm/inFieldLabel/jquery.infieldlabel.js')
            ->registerScriptFile('/js/plugins/clientForm/clientForm.js')
            ->registerCssFile('/js/plugins/clientForm/form.css')->registerScript(
            $id . '_baseForm', "$('#{$id}').clientForm()");
    }


    public function renderBody()
    {
        $output = parent::renderBody();

        if (!($this->getParent() instanceof self))
        {
            if ($this->side == 'admin')
            {
                $this->attributes['class'] = 'admin_form';
                return $this->getParent()->msg('Поля отмеченные * обязательны.', 'info') . $output;
            }
        }

        return $output;
    }


    public function renderElement($element)
    {
        if (is_string($element))
        {
            if (($e = $this[$element]) === null && ($e = $this->getButtons()->itemAt($element)) === null
            )
            {
                return $element;
            }
            else
            {
                $element = $e;
            }
        }

        if ($element instanceof CFormInputElement)
        {
            if ($element->type === 'hidden')
            {
                return "<div style=\"visibility:hidden\">\n" . $element->render() . "</div>\n";
            }
            else
            {
                return $this->_renderElement($element);
            }
        }
        else if ($element instanceof CFormButtonElement)
        {
            return $element->render() . "\n";
        }
        else
        {
            return $element->render();
        }
    }


    private function _renderElement($element)
    {
        if ($element instanceof self)
        {
            $this->_addClassesAdmin($element);
            return $element->render();
        }

        $this->runSideMethod('_addClasses', $element);

        $class = $element->type;
        if (isset($element->attributes['parentClass']))
        {
            $class .= ' ' . $element->attributes['parentClass'];
        }

        $tpl = '_' . $this->side . 'Form';

        $res = "<dl class='$class'><dd>";
        $res .= Yii::app()->controller->renderPartial('application.views.layouts.' . $tpl, array(
            'element' => $element,
            'form'    => $element->parent
        ), true);
        $res .= '</dd></dl>';

        return $res;
    }


    private function _addClassesAdmin($element)
    {
        $data = $element->type;
        $attr = 'class';
        switch ($element->type)
        {
            case 'date':
                $data = array('class'=> $data . ' text date_picker');
                $attr = 'htmlOptions';
                break;
            case 'password':
                $data = $data . ' text';
                break;
            case 'dropdownlist':
                $data = $data . ' cmf-skinned-select';
                break;
            default:
                ;
        }
        $element->attributes[$attr] = $data;
        return $element;
    }


    private function _addClassesClient(&$element)
    {

    }


    public function clear()
    {
        $this->_clear = true;
    }


    public function renderButtons()
    {
        if (!($this->getParent() instanceof self) && !$this->buttons->itemAt('back') &&
            $this->cancel_button_show && $this->side == 'admin'
        )
        {
            $this->buttons->add("back", array(
                'type'  => 'button',
                'value' => 'Отмена',
                'url'   => Yii::app()->controller->createUrl('manage'),
                'class' => 'back_button submit small'
            ));
        }

        return parent::renderButtons();
    }


    /***** Функции оформления формы *******/

    function addAttributesToButtons()
    {
        foreach ($this->buttons as $i => $button)
        {
            $this->runSideMethod('_addAttributesToButtons', $button);
            $this->buttons[$i] = $button;
        }
    }


    private function _addAttributesToButtonsAdmin($button)
    {
        $length = mb_strlen($button->value, 'utf-8');

        $class = isset($button->attributes['class']) ? $button->attributes['class'] . " submit" : "submit";

        if ($length > 11)
        {
            $class .= ' long';
        }
        elseif ($length > 6)
        {
            $class .= ' mid';
        }
        else
        {
            $class .= ' small';
        }

        $button->attributes['class'] = $class;
        return $button;
    }


    private function _addAttributesToButtonsClient($button)
    {
        return $button;
    }


    function formatDateAttributes()
    {
        if (!$this->model)
        {
            return false;
        }

        $model = $this->model;
        foreach ($model->attributes as $attr => $value)
        {
            if (Yii::app()->dater->isDbDate($value))
            {
                $model->$attr = Yii::app()->dater->formFormat($value);
            }
        }

        $this->model = $model;
    }

}
