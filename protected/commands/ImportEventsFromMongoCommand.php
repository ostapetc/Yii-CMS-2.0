<?php

/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 24.11.12
 * Time: 18:44
 * To change this template use File | Settings | File Templates.
 */

class ImportEventsFromMongoCommand extends CConsoleCommand
{
    public function run($args)
    {
//        echo date('Y-m-d', strtotime('Aug 9 2008')); die;

        $mongo      = new Mongo();
        $collection = $mongo->mma->events;
        $cursor     = $collection->find()->sort(['date_import' => 1]);

        foreach ($cursor as $item)
        {
            if (!isset($item['name'])) continue;

            $item['date_import'] = time();

            $collection->update(array('_id' => $item['_id']), $item);

            $name = trim(trim($item['name']));
            $date = str_replace('/ ', '', $item['date']);
            $date = date('Y-m-d', strtotime($date));

            $mma_event = MMAEvent::model()->findByAttributes(['name' => $name]);
            if (!$mma_event)
            {
                $mma_event = new MMAEvent();
                $mma_event->name       = $name;
                $mma_event->sherdog_id = $item['id'];
                $mma_event->date       = $date;
                $mma_event->save();

                if ($mma_event->errors)
                {
                    p($mma_event->errors);
                    $this->log("Не могу сохранить MMAEvent: " . $mma_event->errors_str, CLogger::LEVEL_ERROR);
                }
            }
        }
    }


    private function log($msg, $level = CLogger::LEVEL_INFO)
    {
        Yii::log($msg, $level, 'ImportEventsFromMongoCommand');
    }
}
