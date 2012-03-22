<?php

class BaseForm extends CForm
{
    private $_clear = false;

    public $side;

    public $back_button_show = true;

    public $inputElementClass = null;


    public function __construct($config, $model = null, $parent = null)
    {
        if ($this->side == null)
        {
            $this->side = Yii::app()->controller instanceof AdminController ? 'admin' : 'client';
        }

        if ($this->inputElementClass == null)
        {
            $this->inputElementClass = ucfirst($this->side) . 'FormInputElement';
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


    public function __toString()
    {
        if ($this->side == 'client') //only bootstrap
        {
            $this->activeForm['class']                = 'BootActiveForm';
            $this->activeForm['errorMessageCssClass'] = "help-block";
        }

        if (!($this->parent instanceof self))
        {
            $cs = Yii::app()->clientScript;
            if ($this->side == 'client')
            {
                $cs->registerCssFile('/css/site/form.css');
            }
            elseif ($this->side == 'admin')
            {
                $cs->registerCssFile('/css/admin/form.css');
            }

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


    public function renderBody()
    {
        $output = parent::renderBody();

        if (!($this->getParent() instanceof self) && $this->side == 'admin')
        {
            $this->attributes['class'] = 'admin_form';
            return $this->getParent()->msg(t('Поля отмеченные * обязательны.'), 'info') . $output;
        }

        return $output;
    }


    public function renderElement($element)
    {
        if (is_string($element))
        {
            if (($e = $this[$element]) === null && ($e = $this->getButtons()->itemAt($element)) === null)
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
                if ($element instanceof self)
                {
                    $this->_addClassesAdmin($element);
                    return $element->render();
                }
                $class = $element->type;

                $res = "<dl class='{$class} control-group'><dd>";
                $res .= $element->renderLabel();
                $res .= $element->renderInput();
                $res .= $element->renderError();
                $res .= '</dd></dl>';

                return $res;
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

    public function clear()
    {
        $this->_clear = true;
    }


    public function renderButtons()
    {
        $is_admin_form = !($this->getParent() instanceof self) && $this->side == 'admin';
        if ($this->back_button_show && !$this->buttons->itemAt('back') && $is_admin_form)
        {
            $this->buttons->add("back", array(
                'type'  => 'link',
                'label' => t('Отмена'),
                'url'   => Yii::app()->controller->createUrl('manage'),
                'class' => 'back_button btn btn-danger'
            ));
        }

        $output = '';
        foreach ($this->getButtons() as $button)
        {
            $output .= $this->renderElement($button);
        }
        return $output !== '' ? "<dl class=\"buttons control-group\"><dd>" . $output . "<dd></dl>\n" : '';
    }


    /***** Функции оформления формы *******/
    function addAttributesToButtons()
    {
        foreach ($this->buttons as $i => $button)
        {
            $button->attributes['class'] = 'btn';
            if ($button->type == 'submit')
            {
                $button->attributes['class'] .= ' btn-primary';
            }
            $this->buttons[$i] = $button;
        }
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
