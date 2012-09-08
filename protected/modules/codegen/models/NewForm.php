<?php
/** 
 * @property        $model
 * @property string $attributeLabel the attribute label
 * @property string $error          the error message. Null is returned if no error.
 * @property CList  $eventHandlers  list of attached event handlers for the event
 * 
 */

class NewForm extends FormModel
{
    public $model;


    public function rules()
    {
        return array(
            array('model', 'required')
        );
    }
}























