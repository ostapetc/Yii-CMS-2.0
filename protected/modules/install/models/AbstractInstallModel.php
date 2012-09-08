<?php
/** 
 * Base model for Install module.
 * 
 * 
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
    public static function loadFromSession()
    {
        $class = get_called_class();
        $model = new $class();
        $model->attributes = Yii::app()->user->getState('install_'.$class);
        return $model;
    }
}