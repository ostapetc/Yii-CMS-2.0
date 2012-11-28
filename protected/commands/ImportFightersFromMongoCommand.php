<?php

/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 24.11.12
 * Time: 18:44
 * To change this template use File | Settings | File Templates.
 */

class ImportFightersFromMongoCommand extends CConsoleCommand
{
    public function run($args)
    {
        $mongo      = new Mongo();
        $collection = $mongo->mma->fighters;
        $cursor     = $collection->find()->sort(array("date_import" => 1))->limit(20000);

        foreach ($cursor as $item)
        {
            $item['date_import'] = time();
            //$collection->update(array('_id' => $item['_id']), $item);

            $fighter = Fighter::model()->findByAttributes(array('sherdog_id' => $item['id']));
            if ($fighter)
            {
                $fighter->date_update = new CDbExpression('NOW()');
            }
            else
            {
                $fighter = new Fighter();
                $fighter->sherdog_id = $item['id'];
            }

            $image = trim($item['image']);
            if ($image && !$fighter->image)
            {
                $fighter->image = $image;
            }

            $fighter->name             = trim($item['name']);
            $fighter->nickname         = trim($item['nickname']);
            $fighter->birthdate        = trim($item['birthdate']);
            $fighter->city             = trim($item['city']);
            $fighter->height           = $item['height'] ? number_format($item['height'] * 30.48, 1) : null;
            $fighter->weight           = $item['weight'] ? number_format($item['weight'] * 0.45359237, 1) : null;
            $fighter->class            = trim($item['class']);
            $fighter->association      = trim($item['association']);
            $fighter->wins             = trim($item['wins'])   ?: 0;
            $fighter->losses           = trim($item['losses']) ?: 0;
            $fighter->win_ko           = trim($item['win_ko']);
            $fighter->win_submissions  = trim($item['win_submissions']);
            $fighter->win_decisions    = trim($item['win_decisions']);
            $fighter->loss_ko          = trim($item['loss_ko']);
            $fighter->loss_submissions = trim($item['loss_submissions']);
            $fighter->loss_decisions   = trim($item['loss_decisions']);

            $is_new = $fighter->isNewRecord;

            if ($fighter->save())
            {
                $msg = $is_new ? "Добавлен боец  {$fighter->link}" : "Обновлен боец {$fighter->link}";
                $this->log($msg);
            }
            else
            {
                $this->log("Ошибка сохранения: " . $fighter->errors_str);
            }
        }
    }


    private function log($msg, $level = CLogger::LEVEL_INFO)
    {
        Yii::log($msg, $level, 'ImportFightersFromMongoCommand');
    }
}
