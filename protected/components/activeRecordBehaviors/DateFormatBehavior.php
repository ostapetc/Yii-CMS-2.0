<?php

class DateFormatBehavior extends CActiveRecordBehavior
{
    const DB_DATE_TIME_FORMAT = 'Y-m-d h:i:c';
    const DB_DATE_FORMAT      = 'Y-m-d';
	
    public $not_formattable_attrs = array('date_create', 'date_update');
     

    public function beforeSave()
    {
        $model = $this->getOwner();

        $columns = $this->getOwner()->metaData->columns;
        foreach ($columns as $i => $column)
        {
            $attr = $column->name;
			
            if (in_array($attr, $this->not_formattable_attrs)) 
            {
            	continue;
            }

            if (!$model->$attr)
            {
                continue;
            }            
            
            if (strtoupper($model->$attr) == 'NOW()') 
            {
            	continue;
            }
            
            if (Yii::app()->dater->isDbDate($model->$attr)) 
            {
            	continue;	
            }

            if ($column->dbType == 'date')
            {	
            	
                $model->$attr = date(self::DB_DATE_FORMAT, strtotime($model->$attr));
            }
            else if (in_array($column->dbType, array('timestamp', 'datetime')))
            {	
                $model->$attr = date(self::DB_DATE_TIME_FORMAT, strtotime($model->$attr));
            }
        }
    }
}
