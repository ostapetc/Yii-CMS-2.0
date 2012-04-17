<?

class MetaTagBehavior extends ActiveRecordBehavior
{
    private static $_meta_tags;

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


    public function metaTags()
    {
        $key = get_class($this->owner) . '_' . $this->owner->primaryKey;
        if (!isset(self::$_meta_tags[$key]))
        {
            $meta_tags = array(
                "title"       => "",
                "description" => "",
                "keywords"    => ""
            );

            $meta_data = MetaTag::model()->findByAttributes(array(
                'object_id' => $this->owner->primaryKey,
                'model_id'  => get_class($this->owner)
            ));

            if ($meta_data)
            {
                $meta_tags["title"]       = $meta_data->title;
                $meta_tags["description"] = $meta_data->description;
                $meta_tags["keywords"]    = $meta_data->keywords;
            }

            self::$_meta_tags[$key] = $meta_tags;
        }

        return self::$_meta_tags[$key];
    }

    public function beforeInitForm($event)
    {
        $elements = $event->sender->getElements();
        $elements['meta_tags'] = array('type'=>'meta_tags');
        $event->sender->setElements($elements);
    }
}










