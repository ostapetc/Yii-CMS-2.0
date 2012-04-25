<?

class DateFormatBehavior extends ActiveRecordBehavior
{
    const DB_DATE_TIME_FORMAT = 'Y-m-d h:i:c';
    const DB_DATE_FORMAT      = 'Y-m-d';

    public $not_formattable_attrs = array('date_create', 'date_update');


    public function beforeSave($event)
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


    /**
     * Добавляет гораничение по временному диапазону на заданный атрибут.
     * Виджет для временных диапазонов - FJuiDatePicker
     *
     * @param $criteria
     * @param $attribute_name
     */
    public function addTimeDiapasonCondition($criteria, $attribute_name)
    {
        $attr = $attribute_name;
        if (strpos('.', $attribute_name) !== false)
        {
            list($prefix, $attr) = explode('.', $attribute_name);
        }
        $start = '_' . $attr . '_start';
        $end   = '_' . $attr . '_end';

        if (isset($_GET[$start]) && ($start = strtotime($_GET[$start])))
        {
            $criteria->addCondition($attribute_name . ">='" . date('Y-m-d 00:00:00', $start) . "'");
        }
        if (isset($_GET[$end]) && ($end = strtotime($_GET[$end])))
        {
            $criteria->addCondition($attribute_name . "<='" . date('Y-m-d 23:59:59', $end) . "'");
        }
        return $criteria;
    }

}
