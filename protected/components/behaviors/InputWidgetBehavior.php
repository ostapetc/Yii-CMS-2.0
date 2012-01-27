<?php
class InputWidgetBehavior extends CBehavior
{
    private $_assets;


    /**
     * Возвращает URL до директории assets, модуля, которому принадлежит виджет
     *
     * @return mixed
     */
    public function getAssets()
    {
        if ($this->_assets === null)
        {
            $class = get_class($this->getOwner());
            $base  = 'application.components.formElements.';

            $path = Yii::getPathOfAlias($base . $class . '.assets');
            if ($path)
            {
                $this->_assets = Yii::app()->getAssetManager()->publish($path);
            }
        }

        return $this->_assets;
    }


    public function renderDialog($view, $params = array(), $return = false)
    {
        //без этого отваливаются css тили :-(
        $this->getOwner()->widget('zii.widgets.jui.CJuiDialog', array(
            'options'=> array(
                'autoOpen'=> false,
            ),
        ));

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
        $form_id    = $this->getOwner()->form->activeFormWidget->id;

        // the link that may open the dialog
        echo CHtml::link($options['title'], '#', array(
            'onclick'=> "
            $('#{$this->getOwner()->id}').dialog({$js_options}).bind('dialogclose',function(event) {
                $(this).dialog('destroy').appendTo('#{$form_id}').hide();
            });
            return false;
        ",
        ));

        return $this->getOwner()->render($view, $params, $return);
    }
}
