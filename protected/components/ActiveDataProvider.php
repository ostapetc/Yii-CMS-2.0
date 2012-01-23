<?php
class ActiveDataProvider extends CActiveDataProvider
{
    const PAGE_SIZE = 10;

    public function __construct($modelClass, $config = array())
    {
        if (!isset($config['pagination']['pageSize']))
        {
            if (isset(Yii::app()->session[$modelClass . "PerPage"]) &&
                Yii::app()->controller instanceof AdminController
            )
            {
                $page_size = Yii::app()->session[$modelClass . "PerPage"];
            }
            else
            {
                $reflection = new ReflectionClass($modelClass);

                $page_size = $reflection->getConstant('PAGE_SIZE');
                if (!$page_size)
                {
                    $page_size = self::PAGE_SIZE;
                }
            }

            $config['pagination']['pageSize'] = $page_size;
        }

        parent::__construct($modelClass, $config);
    }

    public function getCriteria()
    {
        $criteria = parent::getCriteria();
        $meta  = CActiveRecord::model($this->modelClass)->meta();

        if (isset($meta['lang']))
        {
            $criteria->addCondition("lang = '" . Yii::app()->language . "'");
        }

        return $criteria;
    }

}
