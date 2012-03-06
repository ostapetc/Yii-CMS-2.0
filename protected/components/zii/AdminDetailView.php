<?php
Yii::import('zii.widgets.CDetailView');
class AdminDetailView extends CDetailView
{

    public function init()
    {
        parent::init();
        foreach($this->attributes as $attribute)
        {
            if(!isset($attribute['name']))
            {
                continue;
            }
            $name = $attribute['name'];
            $value = CHtml::value($this->data,$name);
            if (Yii::app()->dater->isDbDate($value))
            {
                $value = Yii::app()->dater->readableFormat($value);
                if(is_object($this->data))
                {
                    $this->data->{$name}=$value;
                }
                else if (is_array($this->data) && isset($model[$name]))
                {
                    $this->data[$name]=$value;
                }
            }
        }
    }
}
