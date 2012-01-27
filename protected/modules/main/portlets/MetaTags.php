<?php

class MetaTags extends JuiInputWidget
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

        //вывод формы
        $this->renderDialog('MetaTags', array(
            'model'         => $model,
            'dialogOptions' => array(
                'title'   => 'Мета-теги',
            )
        ));
    }
}
