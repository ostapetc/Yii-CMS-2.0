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


    public function afterGridInitColumns($event)
    {
        $grid = $event->sender;
        $data = $grid->dataProvider->data;

        $data_columns = array();

        foreach ($grid->columns as $col)
        {
            if (isset($col->name))
            {
                $data_columns[$col->name] = $col;
            }
        }

        foreach ($data as $item)
        {
            foreach ($item as $attr => $value)
            {
                //if hasn't column for it attr OR if set value of column
                if (!isset($data_columns[$attr]) || $data_columns[$attr]->value != null)
                {
                    continue;
                }

                //if not is date OR datetime
                if (!Yii::app()->dater->isDbDate($value))
                {
                    continue;
                }

                $no_values = array('0000-00-00 00:00:00', '0000-00-00');
                $new_value = in_array($value, $no_values) ? null : Yii::app()->dater->readableFormat($value);

                if (is_array($item))
                {
                    $item[$attr] = $new_value;
                }
                else
                {
                    $item->$attr = $new_value;
                }
            }
        }

        $grid->dataProvider->setData($data);
    }

    public function beforeFormInit($event)
    {
        if (!($model = $event->sender->model))
        {
            return false;
        }

        foreach ($model->attributes as $attr => $value)
        {
            if (Yii::app()->dater->isDbDate($value))
            {
                $model->$attr = Yii::app()->dater->formFormat($value);
            }
        }

        $event->sender->model = $model;
    }

}
