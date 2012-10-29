<?php

/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 09.09.12
 * Time: 18:01
 * To change this template use File | Settings | File Templates.
 */

class SportRelBehavior extends ActiveRecordBehavior
{
    public function afterSave($event)
    {
        $attributes = [
            'object_id' => $this->owner->id,
            'model_id'  => get_class($this->owner)
        ];

        SportRel::model()->deleteAllByAttributes($attributes);

        if (is_array($this->owner->sports_ids))
        {
            foreach ($this->owner->sports_ids as $sport_id)
            {
                $attributes['sport_id'] = $sport_id;

                $sport_rel = new SportRel();
                $sport_rel->attributes = $attributes;
                if (!$sport_rel->save())
                {
                    throw new CException("Can't save SportRel model");
                }
            }
        }
    }


}
