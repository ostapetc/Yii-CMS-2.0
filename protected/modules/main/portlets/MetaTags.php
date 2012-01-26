<?php

class MetaTags extends InputWidget
{
    public function init()
    {
        $class = 'application.components.activeRecordBehaviors.MetaTagBehavior';

        $behaviors = $this->model->behaviors();
        $classes   = ArrayHelper::extract($behaviors, 'class');
        if (!in_array($class, $classes))
        {
            throw new CException("Модель должна иметь поведение: {$class}");
        }

        parent::init();
    }


    public function run()
    {
        $model = new MetaTag;

        if (!$this->model->isNewRecord)
        {
            $meta_tag = MetaTag::model()->findByAttributes(array(
                'object_id' => $this->model->id,
                'model_id'  => get_class($this->model)
            ));

            if ($meta_tag)
            {
                $model = $meta_tag;
            }
        }

        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id'     => 'mydialog',
            // additional javascript options for the dialog plugin
            'options'=> array(
                'title'   => 'Dialog box 1',
                'autoOpen'=> false,
                'width'=>'520px'
            ),
        ));

        $this->render('MetaTags', array(
            'model' => $model
        ));

        $this->endWidget('zii.widgets.jui.CJuiDialog');

        // the link that may open the dialog
        echo CHtml::link('open dialog', '#', array(
            'onclick'=> '$("#mydialog").dialog("open"); return false;',
        ));

    }
}
