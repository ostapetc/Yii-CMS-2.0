<?php
class SqlHelper
{
    public static function arrToCase($caseParam, $values, $alias = '')
    {
        if ($alias)
        {
            $alias .= '.';
        }
        $case = "case {$alias}{$caseParam} ";
        foreach ($values as $key => $val)
        {
            $case .= "when $key then " . $val . ' ';
        }
        $case .= "end";

        return $case;
    }

    public static function in($field, $values, $alias)
    {
        return $alias . '.' . $field . ' IN (' . implode(',', $values) . ')';
    }

    public static function parseManyMany($model, $relation)
    {
        preg_match('/^\s*(.*?)\((.*)\)\s*$/', $model->getMetaData()->relations[$relation]->foreignKey, $matches);
        $fks = preg_split('/\s*,\s*/', $matches[2], -1, PREG_SPLIT_NO_EMPTY);
        return array(
            $matches[1],
            $fks[0],
            $fks[1]
        );
    }
}