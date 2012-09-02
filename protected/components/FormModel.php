<?php
class FormModel extends CFormModel
{
    /**
     * sdfasdf
     *
     * @param CModelEvent $event
     */
    public function onBeforeFormInit($event)
    {
        $this->raiseEvent('onBeforeFormInit', $event);
    }

    /**
     * @param CModelEvent $event
     */
    public function onAfterFormInit($event)
    {
        $this->raiseEvent('onAfterFormInit', $event);
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