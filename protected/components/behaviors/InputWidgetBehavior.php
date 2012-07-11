<?
class InputWidgetBehavior extends CBehavior
{
    private $_assets;


    /**
     * Возвращает URL до директории assets, модуля, которому принадлежит виджет
     *
     * @return mixed
     */
    public function getAssets()
    {
        if ($this->_assets === null)
        {
            $class = get_class($this->getOwner());
            $base  = 'application.components.formElements.';

            $path = Yii::getPathOfAlias($base . $class . '.assets');
            if ($path)
            {
                $this->_assets = Yii::app()->getAssetManager()->publish($path);
            }
        }

        return $this->_assets . '/';
    }


}
