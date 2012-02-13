<?php

class ModuleUrlManager
{
    static function collectRules()
    {
        if (!empty(Yii::app()->modules))
        {
            foreach (Yii::app()->modules as $moduleName => $config)
            {
                try
                {
                    $module = Yii::app()->getModule($moduleName);
                }
                catch (Exception $e)
                {

                }

                //if (!empty($module->urlRules))
                //{
                    //Yii::app()->getUrlManager()->addRules($module->urlRules);
                //}
            }
        }

        return true;
    }
}
