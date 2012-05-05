<?php
class AbstractInstallModel extends FormModel
{
    public function saveInSession()
    {
        Yii::app()->user->setState('install_'.get_class($this), $this->attributes);
    }

    /**
     * @static
     * @return AbstractInstalModel
     */
    public function loadFromSession()
    {
        $this->attributes = Yii::app()->user->getState('install_'.get_class($this));
    }
}