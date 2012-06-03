<?
class Form extends CForm
{
    public $back_button_show;

    public $inputElementClass = 'FormInputElement';
    public $buttonElementClass = 'FormButtonElement';

    public $defaultActiveFormSettings = array(
        'class' => 'BootActiveForm',
        'enableAjaxValidation'=>true,
        'clientOptions' => array(
            'validateOnType' => true,
            'validateOnSubmit' => true,
            'afterValidateAttribute' => 'js:function(form, attribute, data, hasError){
                        var cg = $("#"+attribute.inputID).closest(".control-group");
                        hasError ? cg.addClass("error") : cg.removeClass("error");
                        hasError ? cg.removeClass("success") : cg.addClass("success");
                    }',
        'inlineErrors' => false
    ));


    public function __construct($config, $model = null, $parent = null)
    {
        $side = Yii::app()->controller instanceof AdminController ? 'admin' : 'client';

        if ($this->back_button_show === null)
        {
            $this->back_button_show = $side == 'admin';
        }

        if (is_string($config))
        {
            $config = self::getFullAlias($config);
        }

        parent::__construct($config, $model, $parent);

        $this->addAttributesToButtons();
    }


    public function init()
    {
        $this->model->onBeforeFormInit(new CEvent($this));
        parent::init();
        $this->model->onAfterFormInit(new CEvent($this));
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
            $this->activeForm = CMap::mergeArray($this->defaultActiveFormSettings, $this->activeForm);

            try
            {
                //profile form
                $profile_id = 'Form::'.$this->activeForm['id'];
                Yii::beginProfile($profile_id);
                $res = parent::__toString();
                Yii::endProfile($profile_id);
                return $res;
            }
            catch (Exception $e)
            {
                Yii::app()->handleException($e);
            }
        }
    }


    public function renderBody()
    {
        $output = parent::renderBody();

        if (!($this->getParent() instanceof self) && Yii::app()->controller instanceof AdminController)
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
        if ($this->back_button_show && !$this->buttons->itemAt('back'))
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


    public function addAttributesToButtons()
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


    /**
     * TODO: восстановить метод
     */
    public function clear()
    {

    }
}
