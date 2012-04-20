<?php
class FormModel extends CFormModel
{
    /**
     * @param CModelEvent $event
     */
    public function onBeforeInitForm($event)
    {
        $this->raiseEvent('onBeforeInitForm', $event);
    }
}