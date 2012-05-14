<?php
/**
 * Base model for Install module.
 */
class AbstractInstallModel extends FormModel
{
    /**
     * save model attributes in user session for restore late
     */
    public function saveInSession()
    {
        Yii::app()->user->setState('install_'.get_class($this), $this->attributes);
    }

    /**
     * load model attributes from user session
     *
     * @static
     * @return AbstractInstallModel
     */
    public function loadFromSession()
    {
        $this->attributes = Yii::app()->user->getState('install_'.get_class($this));
    }
}