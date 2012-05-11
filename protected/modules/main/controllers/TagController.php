<?php

class TagController extends Controller
{
    public static function actionsTitles()
    {
        return array(
            'AutoComplete' => 'Автодополнение тегов'
        );
    }


    public function actionAutoComplete($term)
    {
        $sql = "SELECT GROUP_CONCAT(name) AS tags_concat
                       FROM " . Tag::tableName() . "
                       WHERE name LIKE :term";
        $term = "%{$term}%";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(':term', $term, PDO::PARAM_STR);

        echo CJSON::encode(explode(',', $command->queryScalar()));
    }
}
