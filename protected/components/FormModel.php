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

    /**
     * @param CModelEvent $event
     */
    public function onAftrerInitForm($event)
    {
        $this->raiseEvent('onAfterInitForm', $event);
    }

    /**
     * @param CModelEvent $event
     */
    public function onBeforeGridInitColumns($event)
    {
        $this->raiseEvent('onBeforeGridInitColumns', $event);
    }

    /**
     * @param CModelEvent $event
     */
    public function onAfterGridInitColumns($event)
    {
        $this->raiseEvent('onAfterGridInitColumns', $event);
    }
}