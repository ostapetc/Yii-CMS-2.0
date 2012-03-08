<?php
Yii::import('zii.widgets.CDetailView');
class AdminDetailView extends CDetailView
{

    public function init()
    {
        parent::init();
        foreach($this->attributes as $attribute)
        {
            if(is_string($attribute))
            {
                if(!preg_match('/^([\w\.]+)(:(\w*))?(:(.*))?$/',$attribute,$matches))
                    throw new CException(Yii::t('zii','The attribute must be specified in the format of "Name:Type:Label", where "Type" and "Label" are optional.'));
                $attribute=array(
                    'name'=>$matches[1],
                    'type'=>isset($matches[3]) ? $matches[3] : 'text',
                );
                if(isset($matches[5]))
                    $attribute['label']=$matches[5];
            }
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
