<?php
/** 
 * 
 * !Accessors - Геттеры и сеттеры класа и его поведений
 * @property       $requirements
 * @property       $mustWritableDirectories
 * @property       $isWritableDirectories
 * 
 */

class Step0 extends CComponent
{
    public function getRequirements()
    {
        return array(
            'PHP' => array(
                'is_support'      => version_compare(phpversion(), '5.3', '>'),
                'version'         => phpversion(),
                'minimal_version' => '5.3',
            ),
            'Reflection' => array(
                'is_support'      => class_exists('Reflection', false),
            ),
            'SPL' => array(
                'is_support'      => extension_loaded("SPL"),
            ),
            'DOMDocument' => array(
                'is_support'      => class_exists("DOMDocument", false),
            ),
            'mcrypt' => array(
                'is_support'      => extension_loaded("mcrypt"),
            ),
            'soap' => array(
                'is_support'      => extension_loaded("soap"),
            ),
        );
    }


    public function getMustWritableDirectories()
    {
        return array('application.modules', 'application.config', 'application.runtime', 'webroot.assets', 'application.config');
    }

    public function getIsWritableDirectories()
    {
        $res = array();
        foreach ($this->getMustWritableDirectories() as $dir)
        {
            $res[$dir] = is_writable(Yii::getPathOfAlias($dir));
        }
        return $res;
    }

}