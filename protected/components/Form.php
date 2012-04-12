<?
class Form extends CForm
{
    public $side;

    public $back_button_show = true;

    public $inputElementClass = null;

    public $defaultActiveFormSettings = array(
        'enableAjaxValidation'=>true,
        'clientOptions' => array(
            'validateOnType' => true,
            'validateOnSubmit' => true,
    ));

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
        if (!($this->parent instanceof self))
        {
            try
            {
                $this->model->onBeforeFormRender(new CEvent($this));
            }
            catch(Exception $e)
            {
                YII_DEBUG ? Yii::app()->handleException($e) : Yii::app()->log($e);
            }

            $this->activeForm = CMap::mergeArray($this->defaultActiveFormSettings, $this->activeForm);

            $this->activeForm['class']        = 'BootActiveForm';
            $this->activeForm['inlineErrors'] = false;

            if (isset($this->activeForm['enableAjaxValidation']) && $this->activeForm['enableAjaxValidation'])
            {
                $this->activeForm['clientOptions']['validateOnType'] = true;
                $this->activeForm['clientOptions']['afterValidateAttribute'] = 'js:function(form, attribute, data, hasError){
                    var cg = $("#"+attribute.inputID).closest(".control-group");
                    hasError ? cg.addClass("error") : cg.removeClass("error");
                    hasError ? cg.removeClass("success") : cg.addClass("success");
                }';
            }

            try
            {
                $profile_id = 'Form::'.$this->activeForm['id'];
                //profile form
                Yii::beginProfile($profile_id);
                $res = parent::__toString();
                Yii::endProfile($profile_id);
                return $res;
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
            if($element->type==='hidden')
                return "<div style=\"visibility:hidden\">\n".$element->render()."</div>\n";
            else
                return "<dl class='{$element->type} control-group'><dd>\n".$element->render()."</dd></dl>\n";
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

    public function renderButtons()
    {
        $is_admin_form = !($this->getParent() instanceof self) && $this->side == 'admin';
        if ($this->back_button_show && !$this->buttons->itemAt('back') && $is_admin_form)
        {
            $this->buttons->add("back", array(
                'type'  => 'link',
                'label' => t('Отмена'),
                'href'  => Yii::app()->controller->createUrl('manage'),
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


    public function getElements()
    {
        $elements = parent::getElements();
        foreach ($elements as $element)
        {
            if (isset($element->attributes['prompt']))
            {
                $element->attributes['prompt'] = t($element->attributes['prompt']);
            }
        }

        return $elements;
    }
}
