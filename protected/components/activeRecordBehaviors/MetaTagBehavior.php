<?php

class MetaTagBehavior extends CActiveRecordBehavior
{
    public function afterSave($event)
    {
        $attributes = Yii::app()->request->getParam('MetaTag');
        if ($attributes)
        {
            $meta_tag = MetaTag::model()->findByAttributes(array(
                'object_id' => $this->owner->id,
                'model_id'  => get_class($this->owner)
            ));

            if (!$meta_tag)
            {
                $meta_tag = new MetaTag;
            }

            $attributes['object_id'] = $this->owner->id;
            $attributes['model_id']  = get_class($this->owner);

            $meta_tag->attributes = $attributes;
            $meta_tag->save();
        }

        return parent::afterSave($event);
    }


    public function afterDelete($event)
    {
        MetaTag::model()->deleteAllByAttributes(array(
            'object_id' => $this->owner->id,
            'model_id'  => get_class($this->owner)
        ));

        return parent::afterDelete($event);
    }


    public function relations()
    {
        return array(
            'meta_tags' => array(self::HAS_MANYs)
        );
    }
}
