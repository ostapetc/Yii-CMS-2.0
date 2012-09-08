<?php
/** 
 * @property        $class
 * @property        $genetive
 * @property        $instrumental
 * @property        $accusative
 * @property string $attributeLabel the attribute label
 * @property string $error          the error message. Null is returned if no error.
 * @property CList  $eventHandlers  list of attached event handlers for the event
 * 
 */

class Crud extends FormModel
{
    public $class;

    public $genetive;

    public $instrumental;

    public $accusative;


    public function rules()
    {
        return array(
            array('class, genetive, instrumental, accusative', 'required')
        );
    }


}


